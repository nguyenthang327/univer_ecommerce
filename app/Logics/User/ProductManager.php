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

    public function createProduct($parameters, $gallery = [])
    {
        $product = Product::create($parameters);
        if ($gallery && !empty($gallery)) {
            $path = PRODUCT_DIR . '/' . $product->id . '/';
            foreach ($gallery as $key => $value) {
                $file = json_decode($value, true);
                $destination = $path . basename($file['file_path']);
                $this->moveFile($file['file_path'], $destination);

                $parameters['gallery'][] = [
                    'file_name' => $file['file_name'],
                    'file_path' => $destination,
                ];
            }
        }
        if (isset($parameters['gallery']) && !empty($parameters['gallery'])) {
            $product->update(['gallery' => $parameters['gallery']]);
        }
        return $product;
    }

    public function updateProduct($product, $parameters, $gallery = [])
    {
        $parameters['gallery'] = null;
        if ($gallery && !empty($gallery)) {
            $path = PRODUCT_DIR . '/' . $product->id . '/';
            $oldGallery = $product->gallery ?? [];
            foreach ($gallery as $key => $value) {
                $file = json_decode($value, true);
                $destination = $path . basename($file['file_path']);
                if (!in_array($file, $oldGallery)) {
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
    public function createOrUpdateOption($request, $product)
    {
        $checkChange = false;
        if (isset($request->option_id) && isset($request->option_name)  && isset($request->option_value)) {
            foreach ($request->option_id as $key => $value) {
                $optionValue = array_map('trim', explode("|", $request->option_value[$key]));
                $optionValue = array_filter($optionValue, function ($opVal) {
                    return strlen($opVal) > 0 && $opVal !== null;
                });
                $optionValue = array_values($optionValue);
                $optionValue = array_unique($optionValue);
                if (empty($optionValue)) {
                    return [
                        'status' => false,
                        'position' => ++$key,
                    ];
                }
                if ($value == null) {
                    $option = ProductOption::create([
                        'name' => $request->option_name[$key],
                        'product_id' => $product->id,
                    ]);
                    $data = [];
                    foreach ($optionValue as $val) {
                        $data[] = [
                            'value' => $val,
                            'product_id' => $product->id,
                            'product_option_id' => $option->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                    if (count($data) > 0) {
                        ProductOptionValue::insert($data);
                    }
                } else {
                    $option = ProductOption::with('optionValues')
                        ->where('id', $value)
                        ->where('product_id', $product->id)
                        ->first();
                    $option->name = $request->option_name[$key];
                    $option->save();

                    $optionValueOld = $option->optionValues->pluck('value')->toArray();
                    $diffOld = array_diff($optionValueOld, $optionValue);
                    $diffNew = array_diff($optionValue, $optionValueOld);

                    if (count($diffOld) > 0) {
                        ProductOptionValue::whereIn('value', $diffOld)
                            ->where('product_option_id', $option->id)
                            ->where('product_id', $product->id)
                            ->delete();
                        $checkChange = true;
                    }
                    if (count($diffNew) > 0) {
                        $data = [];
                        foreach ($diffNew as $key => $val) {
                            $data[] = [
                                'value' => $val,
                                'product_id' => $product->id,
                                'product_option_id' => $option->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                        if (count($data) > 0) {
                            ProductOptionValue::insert($data);
                            $checkChange = true;
                        }
                    }
                }
            }

            $productNow = Product::with('optionValues', 'options', 'skus', 'variants')->where('id', $product->id)->first();
            // case add option value
            if ($product->options->count() != $productNow->options->count()) {
                $product->skus()->delete(); // tạo db khi sku delete thì delete variants tương ứng với sku đó.
                $optionValuesNow = $productNow->optionValues->groupBy('product_option_id')->values()->toArray();
                $variants = Product::generateVariant($optionValuesNow);
                $productNow->saveVariant($variants);
            } else {
                // Case change option value
                if ($checkChange) {
                    $optionValuesOld = $product->optionValues->values()->toArray();
                    $optionValuesNow = $productNow->optionValues->values()->toArray();

                    $diffOld = array_udiff(
                        $optionValuesOld,
                        $optionValuesNow,
                        fn ($a, $b) => $a <=> $b
                    );
                    $diffNow = array_udiff(
                        $optionValuesNow,
                        $optionValuesOld,
                        fn ($a, $b) => $a <=> $b
                    );

                    // $diffOld = array_diff(array_column($optionValuesOld, 'id'), array_column($optionValuesNow, 'id'));
                    // $diffNow = array_diff(array_column($optionValuesNow, 'id'), array_column($optionValuesOld, 'id'));
                    if (!empty($diffOld)) {
                        $idSku = ProductVariant::whereIn('product_option_value_id', array_column($diffOld, 'id'))->pluck('sku_id');
                        ProductSku::whereIn('id', $idSku)->delete();
                    }
                    if (!empty($diffNow)) {
                        $groupedDataDiff = array_reduce($diffNow, function($result, $item) {
                            $result[$item['product_option_id']][] = $item;
                            return $result;
                        }, []);

                        $variants = Product::generateVariant($groupedDataDiff);
                        if($productNow->options->count()>1){
                            $variants = array_filter($variants, function($item) {
                                return count($item) > 1;
                            });
                        }
                        $dataOption = $productNow->optionValues->whereNotIn('id', array_column($diffNow, 'id'))->groupBy('product_option_id')->values()->toArray();
                        $result = [];
                        foreach($diffNow as $val1){
                            foreach($dataOption as $val2){
                                if($val1['product_option_id'] != $val2[0]['product_option_id']){
                                    foreach($val2 as $value){
                                        $result[] = [$val1, $value];
                                    }
                                    break;
                                }
                            }
                        }
                        $variants = array_merge($variants, $result);
                        $productNow->saveVariant($variants);
                    }
                }else{
                    $optionValuesNow = $productNow->optionValues->groupBy('product_option_id')->values()->toArray();
                    $variantsNew = Product::generateVariant($optionValuesNow);
                    // dump( $optionValuesNow);
                    $variantsNow = $productNow->variants->groupBy('sku_id')->values()->toArray();
                    // dd($variantsNow, $variantsNew);
                    
                    // $arrDimention = 0;
                    $append = [];
                    if(!empty($variantsNew)){
                        $arrDimention = count($variantsNew[0]);
                        foreach($variantsNew as $variantNew){
                            $check = false;
                            foreach($variantsNow as $variantNow){
                                $count = 0;
                                for($i = 0; $i < $arrDimention; ++$i){
                                    for($j = 0; $j < $arrDimention; ++$j){
                                        if($variantNew[$i]['id'] == $variantNow[$j]['product_option_value_id'] && $variantNew[$i]['product_option_id'] == $variantNow[$j]['product_option_id']){
                                            ++$count;
                                        }
                                    }
                                }
                                if($count == $arrDimention){
                                    // $append[] = $variantNew;
                                    $check = true;
                                    break;
                                }
                            }
                            if($check == false){
                                $append[] = $variantNew;
                            }
                        }
                    }
                    if(!empty($append)){
                        // $variants = Product::generateVariant($append);
                        // dd($variants);
                        $productNow->saveVariant($append);
                    }
                }
            }
            // dd(1);
            return [
                'status' => true,
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
