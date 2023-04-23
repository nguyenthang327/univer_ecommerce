<?php

namespace App\Http\Requests\Frontend;

use App\Models\Order;
use App\Rules\Frontend\CheckCouponRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'prefecture_id' => 'required|exists:prefectures,id',
            'district_id' => 'required|exists:districts,id',
            'commune_id' => 'required|exists:communes,id',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:'. Order::PAYMENT_CASH . ','. Order::PAYMENT_PAYPAL,
            'code' => ['nullable', new CheckCouponRule()],
            'phone' => 'required|digits_between:10,11',
        ];
    }
}
