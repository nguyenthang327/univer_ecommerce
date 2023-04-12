<?php

namespace App\Http\Requests\Frontend;

use App\Logics\Frontend\ProductManager;
use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
        ];

        $productManager = new ProductManager();
        $dataProduct = $productManager->checkProductType($this->product_id);
        if(!empty($dataProduct)){
            if($dataProduct['checkVariant']){
                $rules[] = [
                    'sku_id' => ['required', 'exists:product_skus,id'],
                    'quantity' => ['required']
                ];
            }else{
                $rules[] = [
                    'quantity' => ['required']
                ];
            }
        }
        
        return $rules;
    }
}
