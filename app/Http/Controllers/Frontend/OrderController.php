<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\OrderStoreRequest;
use App\Logics\Frontend\OrderManager;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
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
        return view($this->pathView . 'checkout');
    }

    public function store(Request $request){
        try{
            DB::beginTransaction();
            $couponID = null;
            if(isset($request->code)){
                $coupon = Coupon::where('code', $request->code)->first();
                $coupon->quantity = $coupon->quantity - 1;
                $coupon->save();
                $couponID = $coupon->id;
            }
            $customer = Auth::guard('customer')->user();
            $cart = Cart::join('cart_detail', 'cart_detail.cart_id', 'carts.id')
                ->leftJoin('products', 'products.id', '=', 'cart_detail.product_id')
                ->leftJoin('product_skus', 'product_skus.id', '=', 'cart_detail.sku_id')
                ->where('carts.customer_id', $customer->id)
                ->select([
                    'cart_detail.id as cart_detail_id',
                    'cart_detail.product_id',
                    'cart_detail.sku_id as cart_sku_id',
                    'cart_detail.quantity as cart_quantity',
                    'products.stock as product_stock',
                    'product_skus.stock as sku_stock',
                    'product_skus.id as sku_id',
                ])
                ->get();

            // foreach()
            // $product = Product::join('product')
            
            dd($cart);
            $param = [
                'full_name' => $request->full_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'payment_method' => $request->payment_method,
                'coupon_id' => $couponID,
            ];

            // return 

            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
        }
    }
}
