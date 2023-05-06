<?php

namespace App\Http\Requests\Admin;

use App\Models\ProductCategory;
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
        // dd($this->thumbnail->get);
        $rules = [
            'category_name' => 'required|max:200|unique:product_categories,name,'. $this->id,
            'thumbnail' => 'nullable|image|max:10240',
            'category_parent_id' => ['nullable', function($attribute, $value, $fail){
                $isParent = ProductCategory::where('id', $value)->whereNull('parent_id')->first();
                if(!$isParent){
                    return $fail(trans('validation.enum', ['attribute' => trans("validation.attributes.$attribute")]));
                }
            }]
        ];

        return $rules;
    }
}
