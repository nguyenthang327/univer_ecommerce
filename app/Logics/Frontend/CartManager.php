<?php

namespace App\Logics\Frontend;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartManager
{
    public function getProductsInCart(){
        $subQuery = ProductVariant::join('product_options', 'product_options.id', 'product_variants.product_option_id')
            ->join('product_option_values', 'product_option_values.id', 'product_variants.product_option_value_id')
            ->select([
                'product_variants.sku_id',
                DB::raw("GROUP_CONCAT(CONCAT(product_options.name, ': ', product_option_values.value)  SEPARATOR ', ') AS attributes")
            ])
            ->groupBy('product_variants.sku_id');
        $customerID = Auth::guard('customer')->user()->id;
        $productsInCart = Cart::join('cart_detail', 'cart_detail.cart_id', '=', 'carts.id')
            ->join('products', 'products.id', '=', 'cart_detail.product_id')
            ->leftJoin('product_skus', 'product_skus.id', '=', 'cart_detail.sku_id')
            ->leftJoinSub($subQuery, 'product_variants', function($leftJoin){
                $leftJoin->on('product_skus.id', '=', 'product_variants.sku_id');
            })
            ->where('carts.customer_id', $customerID)
            ->select([
                'carts.id as cart_id',
                'cart_detail.id as cart_detail_id',
                'products.id as product_id',
                'products.slug as product_slug',
                'product_skus.id as sku_id',
                'products.name as product_name',
                'products.gallery as product_gallery',
                'cart_detail.quantity as quantity',
                'product_variants.attributes',
                DB::raw('
                    (CASE WHEN
                        product_skus.id is not null
                            THEN 
                                product_skus.price - IF(products.discount > 0, products.discount *  product_skus.price / 100, 0)
                            ELSE 
                                products.price - IF(products.discount > 0, products.discount *  products.price / 100, 0)
                    END) AS price
                '),
                DB::raw('
                    (CASE WHEN
                        product_skus.id is not null
                            THEN 
                                product_skus.stock
                            ELSE 
                                products.stock
                    END) AS stock
                '),
            ])->get();
        return $productsInCart;
    }

}

?>