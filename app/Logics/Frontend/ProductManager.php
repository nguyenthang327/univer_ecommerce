<?php

namespace App\Logics\Frontend;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductManager
{
    public function getProducts($take = null, $property = null){
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
                'products.id',
                'products.name',
                'products.price',
                'products.sku',
                'products.slug',
                'products.stock',
                'products.discount',
                'products.gallery',
                'products.created_at',
            ])
            ->where('products.status', Product::SELL);
           
            if($take){
                $products = $products->take($take);
            }

            if($property){
                if($property == 'is_featured' ){
                    $products = $products->where('is_featured', Product::IS_FEATURE);
                }
                if($property == 'new'){
                    $products = $products->where('products.created_at', '>=', Carbon::now()->subMonth());
                }
            }

        $products = $products->orderBy('products.created_at', 'desc')
            ->get()->toArray();

        return $products;
    }

    public function getProductsPaginate($paginate = null, $request){
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
            ->leftJoin('product_comments', 'product_comments.product_id', '=', 'products.id')
            ->leftJoin('product_category_relation', 'product_category_relation.product_id', '=', 'products.id')
            ->leftJoin('product_categories', 'product_categories.id', '=', 'product_category_relation.category_id')
            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->select([
                'products.id',
                'products.name',
                'products.price',
                'products.sku',
                'products.slug',
                'products.stock',
                'products.discount',
                'products.gallery',
                'products.created_at',
            ])
            ->where('products.status', Product::SELL);

            if(isset($request)){

            }

            if($paginate){
                $products = $products->sortable()->paginate($paginate);
            }else{
                $products = $products->get();
            }

        return $products;
    }

}

?>