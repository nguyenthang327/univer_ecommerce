<?php

namespace App\Logics\Frontend;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductManager
{
    public function getProducts(){
        $products = Product::with(['skus' => function($query){
                $query->select([
                    'product_skus.*',
                    DB::raw('MIN(product_skus.price) as min_price'),
                    DB::raw('MAX(product_skus.price) as max_price'),
                    DB::raw('SUM(product_skus.stock) as total_stock'),
                ])
                ->whereNotNull('product_skus.price')
                ->whereNotNull('product_skus.stock')
                ->groupBy('product_skus.product_id');
            }])
            ->select([
                'products.*',
            ])->take(2)->get();
        return $products;
    }

}

?>