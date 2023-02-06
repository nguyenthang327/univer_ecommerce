<?php

namespace App\Logics\Admin;

use App\Models\ProductCategory;
use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Illuminate\Support\Str;

class CategoryManager
{
    use ImageTrait;
    use StorageTrait;

    public function getProductCategories(){
        $columns = [
            'product_categories.id',
            'product_categories.name',
            'product_categories.thumbnail',
            'product_categories.parent_id',
            'product_categories.slug',
            'product_categories.created_by_admin_id',
            'product_categories.updated_by_admin_id',
            'product_categories.deleted_at',
        ];

        /* multi level
        $categories = ProductCategory::select($columns)
            ->with(['_nLevelCate' => function($q1) use ($columns){
                $q1->select(
                    $columns
                );
            }])
            ->whereNull('product_categories.parent_id')
            ->get();
        */

        // 2 level
        $categories = ProductCategory::select($columns)
            ->with(['_2LevelCate' => function($q1) use ($columns){
                $q1->select(
                    $columns
                );
            }])
            ->whereNull('product_categories.parent_id')
            ->get()
            ->toArray();

        return $categories;
    }

    /**
     * create product category
     * @param $parameters
     * @param $thumbnail
     */
    public function createProductCategory($parameters, $thumbnail = null){
        // create category
        $category = ProductCategory::create($parameters);

        $categoryPath = null;
        if($thumbnail) {
            $extention = $thumbnail->getClientOriginalExtension();
            $thumbnail = $this->resizeImage($thumbnail->getRealPath(), THUMBNAIL_WIDTH);
            $categoryPath = $this->uploadFileByStream($thumbnail, CATEGORY_DIR.'/'.$category->slug.'/'.Str::random(25).'.' . $extention);
        }

        $category->update([
            'thumbnail' => $categoryPath
        ]);
    }


}

?>