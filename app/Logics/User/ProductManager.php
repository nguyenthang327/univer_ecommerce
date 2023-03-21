<?php

namespace App\Logics\User;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Traits\StorageTrait;
use App\Traits\ImageTrait;

class ProductManager
{
    use StorageTrait;
    use ImageTrait;

    public function createProduct($parameters, $gallery = []){
        $product = Product::create($parameters);
        if($gallery && !empty($gallery)){
            $path = PRODUCT_DIR. '/'. $product->id. '/';
            foreach($gallery as $key => $value){
                $file = json_decode($value, true);
                $destination = $path . basename($file['file_path']);
                $this->moveFile($file['file_path'], $destination);

                $parameters['gallery'][] = [
                    'file_name' => $file['file_name'],
                    'file_path' => $destination,
                ];
            }
        }
        if(isset($parameters['gallery']) && !empty($parameters['gallery'])){
            $product->update(['gallery' => $parameters['gallery']]);
        }
        return $product;
    }

    /**
     * process when create or update option
     * @param $request
     * @param $product
     */
    public function createOrUpdateOption($request, $product){
        if(isset($request->option_id) && isset($request->option_name)  && isset($request->option_value)){
            foreach($request->option_id as $key => $value){
                if($value == null){
                    $option = ProductOption::create([
                        'name' => $request->option_name[$key],
                        'product_id' => $product->id,
                    ]);
                    $optionValue = array_map('trim', explode("|", $request->option_value[$key]));
                    $data = [];
                    foreach($optionValue as $val){
                        $data[] = [
                            'value' => $val,
                            'product_id' => $product->id,
                            'product_option_id' => $option->id,
                        ];
                    }
                    if(count($data) > 0){
                        ProductOptionValue::insert($data);
                    }
                }else{
                    $option = ProductOption::with('optionValues')
                        ->where('id', $value)
                        ->where('product_id', $product->id)
                        ->first();
                    $option->name =  $request->option_name[$key];
                    $option->save();

                    $optionValue = array_map('trim', explode("|", $request->option_value[$key]));
                    $optionValueOld = $option->optionValues->pluck('value')->toArray();
                    $diffOld = array_diff($optionValueOld, $optionValue);
                    $diffNew = array_diff($optionValue, $optionValueOld);

                    if(count($diffOld) > 0){
                        ProductOptionValue::whereIn('value', $diffOld)
                            ->where('product_option_id', $option->id)
                            ->where('product_id', $product->id)
                            ->delete();
                    }
                    if(count($diffNew) > 0){
                        $data = [];
                        foreach($diffNew as $key => $val){
                            $data[] = [
                                'value' => $val,
                                'product_id' => $product->id,
                                'product_option_id' => $option->id,
                            ];
                        }
                        if(count($data) > 0){
                            ProductOptionValue::insert($data);
                        }
                    }
                }
            }
        }
    }
}

?>