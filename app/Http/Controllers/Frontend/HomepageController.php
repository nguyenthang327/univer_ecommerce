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
        $take = 12;
        $productFeature = $this->productManager->getProducts($take, 'is_featured');
        $productNew = $this->productManager->getProducts($take, 'new');

        return view($this->pathView . 'index', compact('productFeature', 'productNew'));
    }
}
