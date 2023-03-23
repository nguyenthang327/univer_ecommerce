<?php

namespace App\Logics\User;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductSku;
use App\Models\ProductVariant;
use App\Traits\StorageTrait;
use App\Traits\ImageTrait;
use Carbon\Carbon;

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

    public function updateProduct($product, $parameters, $gallery = []){
        $parameters['gallery'] = null;
        if($gallery && !empty($gallery)){
            $path = PRODUCT_DIR. '/'. $product->id. '/';
            $oldGallery = $product->gallery ?? [];
            foreach($gallery as $key => $value){
                $file = json_decode($value, true);
                $destination = $path . basename($file['file_path']);
                if(!in_array($file, $oldGallery)){
                    $this->moveFile($file['file_path'], $destination);
                }

                $parameters['gallery'][] = [
                    'file_name' => $file['file_name'],
                    'file_path' => $destination,
                ];
            }
        }

        Product::where('products.id', $product->id)->update($parameters);
    }

    /**
     * process when create or update option
     * @param $request
     * @param $product
     */
    public function createOrUpdateOption($request, $product){
        $checkChange = false;
        // dd($product->options->count(), $product->optionValues->count());
        if(isset($request->option_id) && isset($request->option_name)  && isset($request->option_value)){
            foreach($request->option_id as $key => $value){
                $optionValue = array_map('trim', explode("|", $request->option_value[$key]));
                $optionValue = array_filter($optionValue, function($opVal) {
                    return strlen($opVal) > 0 && $opVal !== null;
                });
                $optionValue = array_values($optionValue);
                $optionValue = array_unique($optionValue);
                if(empty($optionValue)){
                    return [
                        'status' => false,
                        'position' => ++$key,
                    ];
                }
                if($value == null){
                    $option = ProductOption::create([
                        'name' => $request->option_name[$key],
                        'product_id' => $product->id,
                    ]);
                    $data = [];
                    foreach($optionValue as $val){
                        $data[] = [
                            'value' => $val,
                            'product_id' => $product->id,
                            'product_option_id' => $option->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
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
                    $option->name = $request->option_name[$key];
                    $option->save();

                    $optionValueOld = $option->optionValues->pluck('value')->toArray();
                    $diffOld = array_diff($optionValueOld, $optionValue);
                    $diffNew = array_diff($optionValue, $optionValueOld);

                    if(count($diffOld) > 0){
                        ProductOptionValue::whereIn('value', $diffOld)
                            ->where('product_option_id', $option->id)
                            ->where('product_id', $product->id)
                            ->delete();
                        $checkChange = true;
                    }
                    if(count($diffNew) > 0){
                        $data = [];
                        foreach($diffNew as $key => $val){
                            $data[] = [
                                'value' => $val,
                                'product_id' => $product->id,
                                'product_option_id' => $option->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                        if(count($data) > 0){
                            ProductOptionValue::insert($data);
                            $checkChange = true;
                        }
                    }
                }
            }

            $productNow = Product::with('optionValues', 'options', 'skus', 'variants')->where('id', $product->id)->first();
            if($product->options->count() != $productNow->options->count()){
                $product->skus()->delete(); // tạo db khi sku delete thì delete variants tương ứng với sku đó.
                $optionValues = $productNow->optionValues->groupBy('product_option_id')->values()->toArray();
                $variants = Product::generateVariant($optionValues);
                $productNow->saveVariant($variants);
            }else{
                // th thêm mới
                $optionValueOld = $product->optionValues->pluck('value')->toArray();
            }
            return [
                'status' => true,
                'checkChange' => $checkChange,
            ];
        }
    }

    // public function generateAllVariation($input, $product){
    //     if (! count($input)){
    //         return [];
    //     }
    //         $result = [[]];

    //         foreach ($input as $key => $values) {
    //             $append = [];
    //             foreach ($values as $value) { 
    //                 foreach ($result as $data) {
    //                     $append[] = $data + [$key => $value];
    //                 }
    //             }
    //             $result = $append;
    //         }
    //         // dd($result);

    //         foreach($result as $skuItem){
    //             $productSku = ProductSku::create(['product_id' => $product->id]);
    //             foreach($skuItem as $variantItem){
    //                 ProductVariant::create([
    //                     'product_id' => $product->id,
    //                     'product_option_id' => $variantItem['product_option_id'],
    //                     'product_option_value_id' => $variantItem['id'],
    //                     'sku_id' => $productSku->id,
    //                 ]);
    //             }
    //         }
    // }
}

?>