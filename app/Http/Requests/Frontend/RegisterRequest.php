<?php

namespace App\Http\Requests\Frontend;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'email', function($attribute, $value, $fail){
                $customer = Customer::where('email', $value)->where('status', Customer::STATUS_ACTIVE)->first();
                if($customer){
                    $fail(trans("language.customer_register.exists", ['attribute' => $attribute]));
                }
            }],
            'password' => ['required', 'min:6', 'max:32'],
        ];
    }
}
