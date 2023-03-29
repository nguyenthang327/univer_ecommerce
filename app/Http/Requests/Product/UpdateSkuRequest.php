<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkuRequest extends FormRequest
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
            'sku_id' => 'nullable|array',
            'sku_id.*' => 'nullable|exists:product_skus,id',
            'sku_price' => 'nullable|array',
            'sku_price.*' => 'nullable|numeric|min:0',
            'sku_stock' => 'nullable|array',
            'sku_stock.*' => 'nullable|numeric|min:0',
            'sku_name' => 'nullable|array',
            'sku_name.*' => 'nullable|string|max:255',
            'remove_sku_id' => 'nullable|array',
            'remove_sku_id.*' => 'nullable|exists:product_skus,id',
        ];
    }
}
