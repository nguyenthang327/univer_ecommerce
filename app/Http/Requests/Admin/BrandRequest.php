<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            //
            'brand_name' => 'required|string|max:255|unique:brands,name,' . $this->id,
            'brand_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ];
    }
}
