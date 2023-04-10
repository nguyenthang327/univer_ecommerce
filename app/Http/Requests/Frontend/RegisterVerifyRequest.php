<?php

namespace App\Http\Requests\Frontend;

use App\Models\Customer;
use App\Models\CustomerActivation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RegisterVerifyRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     // return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => ['required','max:6','min:6', function($attribute, $value, $fail){
                $customer = Customer::select([
                        'customers.id',
                        'customers.status',
                    ])
                    ->where('customers.id', $this->id)
                    ->first();
                $activation = CustomerActivation::select('customer_activations.expired_time')
                    ->where('customer_activations.code', $value)
                    ->where('customer_activations.customer_id', $this->id)->first();
                if(!$customer){
                    $fail('Tài khoản không có trong hệ thống!');
                }elseif(!$activation){
                    $fail('Mã code không chính xác!');
                }elseif($customer && $customer->status == Customer::STATUS_ACTIVE){
                    $fail('Tài khoản đã được kích hoạt!');
                }elseif($customer && $activation->expired_time < Carbon::now() ){
                    $fail('Mã code đã hết thời gian sử dụng');
                }
            }],
        ];
    }
}
