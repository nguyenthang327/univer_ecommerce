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
        if(session('coupon_code')){
            
        }
        return view($this->pathView . 'checkout');
    }
}
