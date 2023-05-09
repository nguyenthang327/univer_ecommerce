<?php

namespace App\Http\Requests\Frontend;

use App\Enums\TypeAccountEnum;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email_login' => ['required', 'email', function($attribute, $value, $fail){
                if(TypeAccountEnum::USER->value == $this->type_account){
                    $customer = Customer::where('email', $value)->where('status', Customer::STATUS_INACTIVE)->first();
                    if($customer){
                        $fail(trans("language.customer_login.account_inactive", ['attribute' => trans('validation.attributes.'.$attribute)]));
                    }
                }
            }],
            'password_login' => ['required', 'min:6', 'max:32'],
            'type_account' => 'required:in:' . TypeAccountEnum::USER->value . ','. TypeAccountEnum::ADMIN->value . ',' .  TypeAccountEnum::CUSTOMER->value,
        ];
    }
}
