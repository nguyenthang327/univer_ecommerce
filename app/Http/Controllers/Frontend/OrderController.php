<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\OrderManager;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    //

    protected $pathView = 'frontend.order.';

    protected $orderManager;

    public function __construct(OrderManager $orderManager)
    {
        parent::__construct();
        $this->orderManager = $orderManager;
    }

    public function checkoutView(){
        // $data = $this->globalProductsInCart;
        // dd($data);
        // $subTotal = $this->globalProductsInCart->sum(function($item){
        //     return $item->quantity * $item->price;
        // });
        // }
        return view($this->pathView . 'checkout');
    }
}
