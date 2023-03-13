<?php

namespace App\Logics\User;

use App\Models\Product;
use App\Traits\StorageTrait;
use App\Traits\ImageTrait;

class ProductManager
{
    use StorageTrait;
    use ImageTrait;

    public function createProduct($parameters, $gallery){
        $product = Product::create($parameters);
        if($gallery){
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
        $product->update(['gallery' => $parameters['gallery']]);
        return $product;
    }
}

?>