<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class ProcessPriceService
{
    public static function regularPrice($price, $discount = null){
        // $language = App::getLocale();
        // $currency = '';

        // if($language == 'vi'){
        //     $currency = '₫ ';
        // }else{
        //     $currency = '$';
        // }

        $data = [
            'old' => null, 
            'new' => null,
        ];

        if($discount > 0){
            $data['old'] = '$' . $price;
            $data['new'] = '$' . round($price - ($price * $discount / 100), 2);
        }else{
            $data['new'] = '$' . $price;
        }

        return $data;
    }

    public static function variantPrice($priceMin, $priceMax, $discount = null){
        $data = [
            'old' => null, 
            'new' => null,
        ];

        if((float)$priceMin == (float)$priceMax){
            if($discount > 0){
                $data['old'] = '$' . $priceMin ;
                $data['new'] = '$' . round($priceMin - ($priceMin * $discount / 100), 2);
            }else{
                $data['new'] = '$' . $priceMin;
            }
        }else{
            if($discount > 0){
                $data['old'] = '$' . $priceMin . " - $" . $priceMax;
                $data['new'] = "$" . round($priceMin - ($priceMin * $discount / 100),2) ." - $" . round($priceMax  - ($priceMax * $discount / 100),2);
            }else{
                $data['new'] = '$' . $priceMin . " - $" . $priceMax;
            }
        }

        return $data;
    }
}