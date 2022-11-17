<?php

namespace App\Traits;


use Intervention\Image\ImageManagerStatic as Image;


trait ImageTrait
{
    /**
     * Resize the image and constrain aspect ratio
     *
     * @param $imagePath
     * @param $width
     * @param $height
     * @return \Intervention\Image\Image
     */
    public function resizeImage($imagePath, $width, $height=null)
    {
        // Create instance
        $img = Image::make($imagePath);

        // This method reads the EXIF image profile setting 'Orientation'
        // and performs a rotation on the image to display the image correctly.
        $img->orientate();

        if (!is_null($width) && !is_null($height)) {
            $img->resize($width, $height);
        } else if (is_null($height)) {
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } else if (is_null($width)) {
            $img->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        return $img->encode();
    }
}