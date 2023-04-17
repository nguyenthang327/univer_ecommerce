<?php

namespace App\Http\Requests\Frontend;

use App\Models\Coupon;
use App\Services\DateFormatService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CheckCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => ['required', function($attribute, $value, $fail){
                $coupon = Coupon::where('code', $value)->first();
                if(!$coupon){
                    session()->forget('coupon_code');
                    $fail('Mã code không hợp lệ');
                }else{
                    $start = DateFormatService::dateFormatLanguage($coupon->started_at, 'd/m/Y');
                    $end = DateFormatService::dateFormatLanguage($coupon->ended_at, 'd/m/Y');
                    if($coupon->quantity <= 0){
                        session()->forget('coupon_code');
                        $fail("Mã code này đã hết.");
                    }
                    if($coupon->started_at > Carbon::now()){
                        session()->forget('coupon_code');
                        $fail("Mã code này chỉ sử dụng từ $start đến $end.");
                    }else if($coupon->ended_at < Carbon::now()){
                        session()->forget('coupon_code');
                        $fail("Mã code này đã hết thời gian sử dụng.");
                    }
                }
            }]
        ];
    }
}
