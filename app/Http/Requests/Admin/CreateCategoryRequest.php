<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|max:200|unique:product_categories',
            'thumbnail' => 'nullable|mimes:jpeg,png,jpg|max:10240',
            'parent_id' => 'nullable|exists:product_categories,id',
        ];

        return $rules;
    }
}
