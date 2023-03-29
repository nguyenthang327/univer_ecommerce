<?php

namespace App\Logics\Admin;

use App\Models\ProductCategory;
use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            DB::raw('CONCAT_WS(" " , created.first_name, created.last_name) as created_name'),
            DB::raw('CONCAT_WS(" " , updated.first_name, updated.last_name) as updated_name'),
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
            ->leftJoin('admins as created','product_categories.created_by_admin_id', 'created.id')
            ->leftJoin('admins as updated','product_categories.updated_by_admin_id', 'updated.id')
            ->with(['_2LevelCate'])
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

    /**
     * update product category
     * @param $category
     * @param $parameters
     * @param $thumbnail
     */
    public function updateProductCategory($category, $parameters, $thumbnail = null){
        $old_thumbnail_path = null;
        $thumbnail_path = $category->thumbnail;
        if($thumbnail) {
            $old_thumbnail_path = $category->thumbnail;
            $extention = $thumbnail->getClientOriginalExtension();
            $thumbnail = $this->resizeImage($thumbnail->getRealPath(), THUMBNAIL_WIDTH);
            $thumbnail_path = $this->uploadFileByStream($thumbnail, CATEGORY_DIR.'/'.$category->slug.'/'.Str::random(25).'.' . $extention);
        }

        $parameters += [
            'thumbnail' => $thumbnail_path
        ];

        ProductCategory::where('id', $category->id)->update($parameters);

        if($old_thumbnail_path) {
            // Remove old file
            $this->deleteFile($old_thumbnail_path);
        }
    }


}

?>