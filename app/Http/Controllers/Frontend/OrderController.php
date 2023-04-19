<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\OrderStoreRequest;
use App\Logics\Frontend\OrderManager;
use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function store(OrderStoreRequest $request){
        try{
            DB::beginTransaction();
            $couponID = null;
            if(isset($request->code)){
                $coupon = Coupon::where('code', $request->code)->first();
                $coupon->quantity = $coupon->quantity - 1;
                $coupon->save();
                $couponID = $coupon->id;
            }
            $param = [
                'full_name' => $request->full_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'payment_method' => $request->payment_method,
                'coupon_id' => $couponID,
            ];

            // return 

            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
        }
    }
}
