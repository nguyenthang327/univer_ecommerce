<?php

namespace App\Providers;

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
        $productCategoryManager = new ProductCategoryManager();

        View::composer('*', function($view) use($productCategoryManager){
            $globalProductCategories = $productCategoryManager->getAllCategory();
            $globalCustomer = Auth::guard('customer')->user();
            $view->with('globalProductCategories', $globalProductCategories);
            $view->with('globalCustomer', $globalCustomer);
        });
    }
}
