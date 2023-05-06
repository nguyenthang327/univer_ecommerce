<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'status' => ['required', function($attribute, $value, $fail){
                $order = Order::where('id', $this->id)->first();
                if($order){
                    if($order->payment_method == Order::PAYMENT_CASH){
                        if(!in_array($value, Order::STATUS_GROUP_0)){
                            $fail('Trạng thái không hợp lệ.');
                        }
                    }else{
                        if(!in_array($value, Order::STATUS_GROUP_1)){
                            $fail('Trạng thái không hợp lệ.');
                        }
                    }
                }
            }],
        ];
    }
}
