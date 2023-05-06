<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\CartManager;
use App\Logics\Frontend\ProductCategoryManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    protected $globalProductsInCart = [],
            $globalCustomer,
            $globalProductCategories;


    public function __construct() {

        $productCategoryManager = new ProductCategoryManager();

        $this->middleware(function ($request, $next) {
            $this->globalCustomer = Auth::guard('customer')->user();
            // $globalProductsInCart = [];
            if($this->globalCustomer){
                $cartManager = new CartManager();
                $this->globalProductsInCart = $cartManager->getProductsInCart();
            }
            View::share ( 'globalProductsInCart', $this->globalProductsInCart );
            View::share ( 'globalCustomer', $this->globalCustomer);
            return $next($request);
        });

        $this->globalProductCategories = $productCategoryManager->getAllCategory();
 
        View::share ( 'globalProductCategories', $this->globalProductCategories);
        
     }  
}
