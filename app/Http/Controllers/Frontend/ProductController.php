<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\ProductManager;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    const TAKE = 12;

    protected $pathView = 'frontend.product.';
    protected $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    public function index(Request $request){
        $products = $this->productManager->getProductsPaginate(self::TAKE, $request);

        return view($this->pathView. 'index', compact('products'));
    }

    public function show($slug){
        $product = Product::select([
                'products.*',
                DB::raw("GROUP_CONCAT( CONCAT(product_categories.name, '') SEPARATOR ',' ) AS groupCategory"),
                // 'product_categories.name as prName'
                'brands.name as brand_name',
            ])
            ->leftJoin('product_skus', 'product_skus.product_id', '=', 'products.id')
            ->leftJoin('product_comments', 'product_comments.product_id', '=', 'products.id')
            ->leftJoin('product_category_relation', 'product_category_relation.product_id', '=', 'products.id')
            ->leftJoin('product_categories', 'product_categories.id', '=', 'product_category_relation.category_id')
            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.slug', $slug)
            ->where('products.status', Product::SELL)
//IF(projects.deleted_at is null and projects.id is not null, 1, null)
            ->first();
        // $categoryInProduct = null;
        // if($product->productCategoryRelation->isNotEmpty()){
        // }
        $categoryInProduct = ProductCategory::select(['name', 'slug'])
            ->whereIn('id', $product->productCategoryRelation
            ->pluck('category_id'))
            ->get();
        if(!$product){

        }
        // dd($product);
        return view($this->pathView. 'product-detail', compact('product', 'categoryInProduct'));
    }
}
