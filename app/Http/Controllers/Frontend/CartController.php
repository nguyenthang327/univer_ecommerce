<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\CartManager;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $pathView = 'frontend.cart.';

    protected $cartManager;

    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }
    
    public function index(){
        $take = 12;
        // $cartFeature = $this->cartManager->getcarts($take, 'is_featured');
        // $cartNew = $this->cartManager->getcarts($take, 'new');

        return view($this->pathView . 'cart');
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $customer = Auth::guard('customer')->user();
            $cart = Cart::where('customer_id', $customer->id)->first();

            // $product = Product::leftJoin('product_skus', 'product_skus.product_id', '=', 'products.id')
            //     ->where('products.id', )

            $params = [
                'cart_id' => $request->cart_id,
                'product_id' => $request->product_id,
                'sku_id' => $request->sku_id,
                'quantity' => $request->quantity,
            ];

            CartDetail::where('cart_id', $cart->id);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }


}
