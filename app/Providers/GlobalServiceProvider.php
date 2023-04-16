<?php

namespace App\Providers;

use App\Logics\Frontend\CartManager;
use App\Logics\Frontend\ProductCategoryManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // $productCategoryManager = new ProductCategoryManager();
        // $cartManager = new CartManager();

        // View::composer('*', function($view) use($productCategoryManager, $cartManager){
        //     $globalCustomer = Auth::guard('customer')->user();
        //     $globalProductsInCart = [];
        //     $globalProductCategories = $productCategoryManager->getAllCategory();
        //     if($globalCustomer){
        //         $globalProductsInCart = $cartManager->getProductsInCart();
        //     }
        //     $view->with('globalProductCategories', $globalProductCategories);
        //     $view->with('globalCustomer', $globalCustomer);
        //     $view->with('globalProductsInCart', $globalProductsInCart);
        // });
    }
}
