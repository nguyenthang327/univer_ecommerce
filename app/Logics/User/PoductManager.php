<?php

namespace App\Logics\User;

use App\Traits\StorageTrait;
use App\Traits\ImageTrait;

class ProductManager
{
    use StorageTrait;
    use ImageTrait;

    public function createProduct($parameters, $gallery){
        if($gallery){
            foreach($gallery as $key => $value){
                $file = json_decode($value, true);
            }
        }
    }
}

?>