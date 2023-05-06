<?php

namespace App\Logics\Admin;

use App\Helpers\StringHelper;
use App\Models\Brand;
use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Illuminate\Support\Str;

class BrandManager
{
    use ImageTrait;
    use StorageTrait;

    public function getBrands($request = null){
        $columns = [
            'brands.id',
            'brands.name',
            'brands.logo',
        ];

        $brands = Brand::select($columns);
        $stringHelper = new StringHelper();
        if(isset($request->keyword)) {
            $keyword = $stringHelper->formatStringWhereLike($request->keyword);
            $brands->where('brands.name', 'LIKE', '%'.$keyword.'%');
        }

        return $brands;
    }

    public function createBrand($parameters, $logo = null){
        if($logo) {
            $extention = $logo->getClientOriginalExtension();
            $logo = $this->resizeImage($logo->getRealPath(), BRAND_WIDTH);
            $logo_path = $this->uploadFileByStream($logo, BRAND_DIR.'/'. Str::random(25).'.' . $extention);
            $parameters += [
                'logo' => $logo_path
            ];
        }

        Brand::create($parameters);
    }

    public function updateBrand($brand, $parameters, $logo = null){
        $old_logo_path = null;
        $logo_path = $brand->logo;
        if($logo) {
            $old_logo_path = $brand->logo;
            $extention = $logo->getClientOriginalExtension();
            $logo = $this->resizeImage($logo->getRealPath(), BRAND_WIDTH);
            $logo_path = $this->uploadFileByStream($logo, BRAND_DIR. '/'. Str::random(25).'.' . $extention);
        }

        $parameters += [
            'logo' => $logo_path
        ];

        Brand::where('id', $brand->id)->update($parameters);

        if($old_logo_path) {
            // Remove old file
            $this->deleteFile($old_logo_path);
        }
    }
}

?>