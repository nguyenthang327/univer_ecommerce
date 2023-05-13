<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\ProductManager;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomepageController extends BaseController
{
    //
    protected $pathView = 'frontend.homepage.';

    protected $productManager;

    public function __construct(ProductManager $productManager)
    {
        parent::__construct();
        // $auth = Auth::guard('customer')->user();
        // dd($auth);
        $this->productManager = $productManager;
    }
    
    public function index(){
        $take = 12;
        
        $productFeature = $this->productManager->getProducts($take, 'is_featured');
        $productNew = $this->productManager->getProducts($take, 'new');

        $topFavoriteProduct = Product::with(['skus' => function($query){
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
            ->join('favorite_product', 'favorite_product.product_id', 'products.id')
            ->where('products.status', Product::SELL)
            ->groupBy('products.id')
            ->select([
                'products.*',
                DB::raw('COUNT(IF(favorite_product.product_id = products.id , 1 , null)) as total')
            ])
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        return view($this->pathView . 'index', compact('productFeature', 'productNew', 'topFavoriteProduct'));
    }

     /**
     *  change language
     * 
     * @param string $locale
     * 
     * @return Response
     */ 
    public function changeLanguage($locale)
    {
        $language = Language::where('name', $locale)->first();
        $type = 'vi';
        if($language){
            $type = $language->name;
        }
        App::setLocale($type);
        session()->put('locale', $type);

        return redirect()->back();

    } 
}
