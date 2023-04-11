<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\CartManager;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $pathView = 'frontend.cart.';

    protected $cartManager;

    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }
    
    public function index(){
        $take = 12;
        // $cartFeature = $this->cartManager->getcarts($take, 'is_featured');
        // $cartNew = $this->cartManager->getcarts($take, 'new');

        return view($this->pathView . 'cart');
    }


}
