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
use Illuminate\Http\Response;
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

    public function orderCompletedView(){
        return view($this->pathView . 'order-completed');
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
            
            if(!empty($errors) && $request->payment_method == Order::PAYMENT_CASH){
                DB::commit();
                return redirect()->back();
            }
            if(!empty($errors) && $request->payment_method == Order::PAYMENT_PAYPAL){
                DB::commit();
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => trans('message.product_changed_order_failed'),
                    'data' => null,
                ], Response::HTTP_FORBIDDEN);
            }

            if(isset($coupon)){
                $coupon->save();
            }
            DB::commit();
            if($request->payment_method == Order::PAYMENT_PAYPAL){
                // $html = view('frontend.order.order-completed')->render();
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => trans('message.order_successed'),
                    'data' => null,
                ], Response::HTTP_OK);
            }
            return redirect()->route('customer.order.orderCompletedView')->with([
                // 'status_successed' => trans('message.order_successed'),
            ]);
            return redirect()->back()->with([
                'status_successed' => trans('message.order_successed'),
                'orderCompletedView' => true,
            ]);
            return view($this->pathView.'order-completed');
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            if($request->payment_method == Order::PAYMENT_PAYPAL){
                return response()->json([
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => trans('message.server_error'),
                    'data' => null,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return back()->with([
                'status_failed' => trans('message.order_failed'),
            ]);
        }
    }

    public function orderHistory(){
        $orders = Order::select([
                'orders.*',
                'coupons.discount_percentage',
                DB::raw('CONCAT_WS(", " , orders.address, communes.name, districts.name, prefectures.name) as full_address'),
                DB::raw('SUM(order_detail.subtotal) as total'),
            ])
            ->join('order_detail', 'orders.id', 'order_detail.order_id')
            ->leftJoin('prefectures', 'prefectures.id', 'orders.prefecture_id')
            ->leftJoin('districts', 'districts.id', 'orders.district_id')
            ->leftJoin('communes', 'communes.id', 'orders.commune_id')
            ->leftJoin('customers', 'customers.id', 'orders.customer_id')
            ->leftJoin('coupons', 'coupons.id', 'orders.coupon_id')
            ->where('orders.customer_id', Auth::guard('customer')->user()->id)
            ->groupBy('orders.id')
            ->orderBy('orders.created_at', 'desc');
        
        $orders = $orders = $orders->sortable()->paginate(8);

        return view($this->pathView . 'list-old-order', compact('orders'));
    }

    public function getDetail($id){
        $order = Order::select([
                'orders.*',
                'coupons.discount_percentage',
                'customers.email',
                DB::raw('CONCAT_WS(" ", customers.first_name, customers.last_name) as customer_account_name'),
                DB::raw('CONCAT_WS(", " , orders.address, communes.name, districts.name, prefectures.name) as full_address'),
            ])
            ->with(['orderDetail' => function($query){
                $query->join('products','order_detail.product_id', 'products.id')
                    ->leftJoin('product_skus','order_detail.sku_id', 'product_skus.id')
                    ->select([
                        'order_detail.*',
                        'gallery',
                    ]);
            }])
            ->leftJoin('prefectures', 'prefectures.id', 'orders.prefecture_id')
            ->leftJoin('districts', 'districts.id', 'orders.district_id')
            ->leftJoin('communes', 'communes.id', 'orders.commune_id')
            ->leftJoin('coupons', 'coupons.id', 'orders.coupon_id')
            ->leftJoin('customers', 'customers.id', 'orders.customer_id')
            ->where('orders.customer_id', Auth::guard('customer')->user()->id)
            ->where('orders.id', $id)
            ->first();
        if(!$order){
            return view('frontend.layoutSatatus.404');
        }
        return view($this->pathView . 'order-detail', compact('order'));
    }
}
