<?php

namespace App\Logics\Frontend;

use App\Models\ProductCategory;

class ProductCategoryManager{
    public function getAllCategory(){
        $columns = [
            'product_categories.id',
            'product_categories.name',
            'product_categories.thumbnail',
            'product_categories.parent_id',
            'product_categories.slug',
        ];

        // 2 level
        $categories = ProductCategory::select($columns)
            ->with(['_2LevelCate' => function($query) use($columns){
                $query->select($columns);
            }])
            ->whereNull('product_categories.parent_id')
            ->get()
            ->toArray();
// dd($categories);
        return $categories;
    }
}