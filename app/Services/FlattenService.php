<?php

namespace App\Services;

class FlattenService{

    /**
     * Convert multidimensional array to one dimensional array
     * @param $array
     * @return array
     */
    function arrFlatten($array) {
        $result = [];
        foreach ($array as $item) {
            if (is_array($item)) {
                $result[] = array_filter($item, function($array) {
                    return ! is_array($array);
                });
                $result = array_merge($result, $this->arrFlatten($item));
            }
        }
        return array_filter($result);
    }
}