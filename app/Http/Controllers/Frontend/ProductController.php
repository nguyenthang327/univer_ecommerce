<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreFavoriteProductRequest;
use App\Logics\Frontend\ProductManager;
use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{
    //
    const TAKE = 12;
    const COMMENT_PER_PAGE = 8;
    const RELATED_PRODUCT_LIMIT = 8;

    protected $pathView = 'frontend.product.';
    protected $productManager;

    public function __construct(ProductManager $productManager)
    {
        parent::__construct();
        $this->productManager = $productManager;
    }

    public function index(Request $request){
        $products = $this->productManager->getProductsPaginate(self::TAKE, $request);

        return view($this->pathView. 'index', compact('products'));
    }

    public function show($slug){
        $customer = Auth::guard('customer')->user();
        $product = Product::select([
                'products.*',
                // DB::raw("GROUP_CONCAT( CONCAT(product_categories.name, '') SEPARATOR ',' ) AS groupCategory"),
                // 'product_categories.name as prName'
                'brands.name as brand_name',
                DB::raw('ROUND(AVG(product_comments.rating), 1) as rating_avg'),
                'favorite_product.id as favoriteID',
            ])
            ->with(['skus', 'variants', 'options', 'optionValues', 'productCategoryRelation'])
            ->leftJoin('product_skus', 'product_skus.product_id', '=', 'products.id')
            ->leftJoin('product_comments', 'product_comments.product_id', '=', 'products.id')
            ->leftJoin('product_category_relation', 'product_category_relation.product_id', '=', 'products.id')
            ->leftJoin('product_option_values', 'product_option_values.product_id', '=', 'products.id')
            ->leftJoin('product_variants', 'product_variants.sku_id', '=', 'product_skus.id')
            // ->leftJoin('product_categories', 'product_categories.id', '=', 'product_category_relation.category_id')
            ->leftJoin('favorite_product', function($leftJoin) use ($customer){
                $leftJoin->on('favorite_product.product_id', 'products.id')
                    ->where('favorite_product.customer_id', $customer->id);
            })
            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.slug', $slug)
            ->where('products.status', Product::SELL)
            ->first();

        if(!$product->id){
            return view('frontend.layoutStatus.404');
        }

        $categoryInProduct = ProductCategory::select(['name', 'slug'])
            ->whereIn('id', $product->productCategoryRelation
            ->pluck('category_id'))
            ->get();
       

        $productComments = ProductComment::leftJoin('customers', 'customers.id', 'product_comments.customer_id')
            ->select([
                DB::raw('CONCAT_WS(" ", customers.first_name, customers.last_name) as customer_name'),
                'customers.avatar',
                'product_comments.created_at',
                'product_comments.content',
                'product_comments.id',
                'product_comments.rating',
            ])
            ->where('product_id', $product->id)
            ->orderBy('product_comments.created_at', 'desc')
            ->paginate(self::COMMENT_PER_PAGE);

        $relatedProduct = $this->productManager->getRelatedProduct($product, self::RELATED_PRODUCT_LIMIT);

        return view($this->pathView. 'product-detail', compact('product', 'categoryInProduct', 'productComments', 'relatedProduct'));
    }

    public function listFavoriteProduct(){
        $products = $this->productManager->getListFavoriteProduct();
        // dd($products);
        return view($this->pathView . 'wishlist', compact('products'));
    }

    public function favoriteStore(StoreFavoriteProductRequest $request){
        DB::beginTransaction();
        try{
            $customer = Auth::guard('customer')->user();
            $product = FavoriteProduct::where('customer_id', $customer->id)
                ->where('product_id', $request->product_id)
                ->first();
            if(!$product){
                $customer->favoriteProducts()->attach($request->product_id);
                DB::commit();
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => trans('message.add_product_to_wishlist_successed'),
                    'data' => null,
                ], Response::HTTP_OK);
            }
            $customer->favoriteProducts()->detach($request->product_id);
            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.delete_product_to_wishlist_successed'),
                'data' => null,
            ], Response::HTTP_OK);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => trans('message.server_error'),
                'data' => null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
