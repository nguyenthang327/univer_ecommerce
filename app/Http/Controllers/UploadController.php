<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class UploadController extends Controller
{
    use StorageTrait;
    use ImageTrait;

    /**
     * Upload temporary document file
     *
     * @param Request $request
     * @return Response
     */
    public function uploadTemp(Request $request)
    {
        $file = $request->file('file');
        $fileType = $file->getClientOriginalExtension();
        $fileName =  $file->getClientOriginalName();
        if($request->resize){
            $file = $this->resizeImage($file->getRealPath(), IMAGE_ATTACHMENT_WIDTH, IMAGE_ATTACHMENT_WIDTH);
            $filePath = $this->uploadFileByStream($file, TEMP_DIR.'/'.Str::random(25). '.' . $fileType);
        }
        else{
            $filePath = $this->uploadFile($file, TEMP_DIR.'/'.Str::random(25). '.' . $fileType);
        }
        $data = [
            'file_name' => $fileName,
            'file_path' => $filePath
        ];
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $data
        ], Response::HTTP_OK);
    }
}
