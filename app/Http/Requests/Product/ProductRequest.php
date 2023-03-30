<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'product_name' => 'required|max:255',
            'sku' => 'required|max:255|unique:products,sku,'.$this->id,
            'slug' => 'required|max:500|unique:products,slug,'.$this->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' =>  'nullable|numeric|min:0|max:100',
            'description' => 'nullable',
            'category_id' => 'nullable|array',
            'category_id.*' => 'nullable|exists:product_categories,id',
        ];
    }
}
