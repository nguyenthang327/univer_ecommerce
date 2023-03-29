<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
        $user = Auth::guard('user')->user();
        $rules = [
            'prefecture_id' => 'nullable|exists:prefectures,id',
            'district_id' => 'nullable|exists:districts,id',
            'commune_id' => 'nullable|exists:communes,id',
            'birthday' => 'nullable|date_format:d/m/Y|before:'. $today,
            'phone' => 'required|digits_between:10,11|unique:users,phone,'.$user->id,
            'avatar' => 'nullable|mimes:jpeg,png,jpg|max:10240',
        ];

        return $rules;
    }
}
