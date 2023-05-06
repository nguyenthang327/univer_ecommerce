<?php

namespace App\Rules\Frontend;

use App\Models\Coupon;
use App\Services\DateFormatService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckCouponRule implements Rule
{
    public $msg;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $coupon = Coupon::where('code', $value)->first();
        if(!$coupon){
            $this->msg = 'Mã code không hợp lệ';
            // $fail('');
            return false;
        }else{
            $start = DateFormatService::dateFormatLanguage($coupon->started_at, 'd/m/Y');
            $end = DateFormatService::dateFormatLanguage($coupon->ended_at, 'd/m/Y');
            if($coupon->quantity <= 0){
                $this->msg = 'Mã code này đã hết';
                // $fail("Mã code này đã hết.");
                return false;
            }
            if($coupon->started_at > Carbon::now()){
                // $fail("Mã code này chỉ sử dụng từ $start đến $end.");
                $this->msg = "Mã code này chỉ sử dụng từ $start đến $end.";
                return false;
            }else if($coupon->ended_at < Carbon::now()){
                // $fail("Mã code này đã hết thời gian sử dụng.");
                $this->msg = "Mã code này đã hết thời gian sử dụng.";
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        session()->forget('coupon_code');
        return $this->msg;
    }
}
