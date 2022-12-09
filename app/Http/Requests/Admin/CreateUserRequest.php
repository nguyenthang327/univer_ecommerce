<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateUserRequest extends FormRequest
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
        $today = Carbon::now()->format('d/m/Y');
        $rules = [
            'email' => 'required|email|max:200|unique:users,email',
            'user_name' => 'required|max:200|unique:users,user_name',
            'first_name' => 'required|max:200',
            'last_name' => 'required|max:200',
            'identity_card' => 'required|max:200|unique:users,identity_card',
            'prefecture_id' => 'nullable|exists:prefectures,id',
            'district_id' => 'nullable|exists:districts,id',
            'commune_id' => 'nullable|exists:communes,id',
            'birthday' => 'nullable|date_format:d/m/Y|before:'. $today,
            'phone' => 'required|digits_between:10,11|unique:users,phone',
            'avatar' => 'nullable|mimes:jpeg,png,jpg|max:10240',
        ];

        return $rules;
    }
}
