<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\ProductManager;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    //
    protected $pathView = 'frontend.homepage.';

    protected $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }
    
    public function index(){
        $product = $this->productManager->getProducts();
        dd($product);

        return view($this->pathView . 'index');
    }
}
