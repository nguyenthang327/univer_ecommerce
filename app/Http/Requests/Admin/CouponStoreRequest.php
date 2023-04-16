<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
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
            'code' => 'required|min:4|unique:coupons,code,' . $this->id,
            'discount' => 'required|numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'started_at' => 'required|date_format:d/m/Y',
            'ended_at' => 'required|date_format:d/m/Y|after:started_at'
        ];
    }
}
