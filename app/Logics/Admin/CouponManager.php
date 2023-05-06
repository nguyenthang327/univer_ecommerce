<?php

namespace App\Logics\Admin;

use App\Helpers\StringHelper;
use App\Models\Admin;
use App\Models\Coupon;
use Illuminate\Support\Facades\App;
use App\Models\Language;
use App\Traits\StorageTrait;
use App\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;

class CouponManager
{
/**
     * get all Coupon
     * @param $request
     * @return $coupons
     */
    public function getCouponList($request){
        $columns = [
            'coupons.*',
        ];

        $coupons = Coupon::select(
                $columns,
            );

            $stringHelper = new StringHelper();
            if(isset($request->keyword)) {
                $keyword = $stringHelper->formatStringWhereLike($request->keyword);
                $coupons->where('coupons.code', $keyword);
            }
            if(isset($request->discount)) {
                $coupons->where('coupons.discount_percentage', $request->discount);
            }
            // if(isset($request->birthday)) {
            //     $birthday = Carbon::createFromFormat('d/m/Y',$request->birthday)->format('Y-m-d');
            //     $coupons->where('birthday', $birthday);
            // }
            // if($request->has('deleted')) {
            //     $coupons = $coupons->onlyTrashed();
            // }
        return $coupons;
    }
}

?>