<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class ProcessPriceService
{
    public static function regularPrice($price, $discount = null){
        $language = App::getLocale();
        $currency = '$';
        $arround = 2;

        if($language == 'vi'){
            $currency = '₫';
            $arround = 0;
            $price = $price * 23000;

        }else{
            $currency = '$';
        }

        $data = [
            'old' => null, 
            'new' => null,
        ];

        if($discount > 0){
            $data['old'] =  $currency . number_format($price, $arround);
            $data['new'] =  $currency . number_format(round($price - ($price * $discount / 100), $arround), $arround);
        }else{
            $data['new'] =  $currency . number_format($price, $arround);
        }

        return $data;
    }

    public static function variantPrice($priceMin, $priceMax, $discount = null){
        $language = App::getLocale();
        $currency = '$';
        $arround = 2;

        if($language == 'vi'){
            $currency = '₫';
            $arround = 0;
            $priceMin = $priceMin * 23000;
            $priceMax = $priceMax * 23000;

        }else{
            $currency = '$';
        }

        $data = [
            'old' => null, 
            'new' => null,
        ];

        if((float)$priceMin == (float)$priceMax){
            if($discount > 0){
                $data['old'] =  $currency . number_format($priceMin, $arround);
                $data['new'] =  $currency . number_format(round($priceMin - ($priceMin * $discount / 100), $arround), $arround);
            }else{
                $data['new'] =  $currency . number_format($priceMin, $arround);
            }
        }else{
            if($discount > 0){
                $data['old'] =  $currency . number_format($priceMin, $arround) . " - $currency" . number_format($priceMax, $arround);
                $data['new'] =  $currency  . number_format(round($priceMin - ($priceMin * $discount / 100), $arround), $arround) ." - $currency" .  number_format(round($priceMax  - ($priceMax * $discount / 100),$arround), $arround);
            }else{
                $data['new'] =  $currency . number_format($priceMin, $arround) . " - $currency" . number_format($priceMax, $arround);
            }
        }

        return $data;
    }
}