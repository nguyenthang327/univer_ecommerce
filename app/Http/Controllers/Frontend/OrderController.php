<?php

namespace App\Http\Controllers\Frontend;

use App\Events\CustomerOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\OrderStoreRequest;
use App\Logics\Frontend\OrderManager;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends BaseController
{
    //

    protected $pathView = 'frontend.order.';

    protected $orderManager;

    public function __construct(OrderManager $orderManager)
    {
        parent::__construct();
        $this->orderManager = $orderManager;
    }

    public function checkoutView(){
        // $data = $this->globalProductsInCart;
        // dd($data);
        // $subTotal = $this->globalProductsInCart->sum(function($item){
        //     return $item->quantity * $item->price;
        // });
        // }
        $customer = Auth::guard('customer')->user();
        $cart = Cart::join('cart_detail', 'cart_detail.cart_id', 'carts.id')
            ->where('carts.customer_id', $customer->id)
            ->first();
        if(!$cart){
            return back()->with([
                'status_failed' => trans('language.cart_empty'),
            ]);
        }
        return view($this->pathView . 'checkout');
    }

    public function store(OrderStoreRequest $request){
        try{
            DB::beginTransaction();
            $couponID = null;
            if(isset($request->code)){
                $coupon = Coupon::where('code', $request->code)->first();
                $coupon->quantity = $coupon->quantity - 1;
                $couponID = $coupon->id;
            }
            $customer = Auth::guard('customer')->user();
            $cart = Cart::join('cart_detail', 'cart_detail.cart_id', 'carts.id')
                ->where('carts.customer_id', $customer->id)
                ->first();
            if(!$cart){
                return back()->with([
                    'status_failed' => trans('language.cart_empty'),
                ]);
            }

            $param = [
                'customer_id' => $customer->id,
                'full_name' => $request->full_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'payment_method' => $request->payment_method,
                'status' => $request->payment_method == Order::PAYMENT_CASH ? Order::STATUS_0 : Order::STATUS_1,
                'coupon_id' => $couponID,
            ];

            $errors = $this->orderManager->handleStoreOrder($customer, $param);
            
            if(!empty($errors)){
                DB::commit();
                return redirect()->back();
            }

            if(isset($coupon)){
                $coupon->save();
            }
            DB::commit();
            return redirect()->back()->with([
                'status_successed' => trans('message.order_successed'),
                'orderCompletedView' => true,
            ]);
            return view($this->pathView.'order-completed');
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.order_failed'),
            ]);
        }
    }
}
