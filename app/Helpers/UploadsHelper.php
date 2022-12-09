<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Image;

class UploadsHelper
{
    /**
     * Handle Upload Image
     * @param string $uploadPath
     * @param $name
     * @param $request
     * @return string
     */
    public static function handleUploadFile($uploadPath, $name, $request){
        $fullPath = '';
        if(!$request->hasFile($name)){
            return $fullPath;
        }

        $file = $request->file($name);
        $saveName = $file->hashName();
        $fullPath = $uploadPath . $saveName;

        if(!Storage::disk()->exists($uploadPath)){
            Storage::disk()->makeDirectory($uploadPath);
        }

        Storage::disk()->put($fullPath, file_get_contents($file));
        return $fullPath;

    }

}