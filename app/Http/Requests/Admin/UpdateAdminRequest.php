<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
        $rules = [
            'email' => 'required|email|max:200|unique:admins,email,'.$this->id,
            'user_name' => 'required|max:200|unique:admins,user_name,'.$this->id,
            'first_name' => 'required|max:200',
            'last_name' => 'required|max:200',
            'identity_card' => 'max:200',
            'prefecture_id' => 'nullable|exists:prefectures,id',
            'district_id' => 'nullable|exists:districts,id',
            'commune_id' => 'nullable|exists:communes,id',
            'birthday' => 'nullable|date_format:d/m/Y',
            'phone' => 'nullable|digits_between:10,11',
            'avatar' => 'nullable|mimes:jpeg,png,jpg|max:10240',
        ];

        return $rules;
    }
}
