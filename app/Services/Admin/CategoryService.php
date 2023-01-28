<?php

namespace App\Services\Admin;

use App\Models\ProductCategory;
use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Illuminate\Support\Str;

class CategoryService
{
    use ImageTrait;
    use StorageTrait;

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
            $categoryPath = $this->uploadFileByStream($thumbnail, CATEGORY_DIR.'/'.$category->id.'/'.Str::random(25).'.' . $extention);
        }

        $category->update([
            'thumbnail' => $categoryPath
        ]);
    }
}

?>