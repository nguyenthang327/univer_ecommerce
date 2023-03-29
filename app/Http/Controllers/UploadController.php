<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
            $file = $this->resizeImage($file->getRealPath(), IMAGE_ATTACHMENT_WIDTH);
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

    /**
     * remove file
     *
     * @param Request $request
     * @return Response
     */
    public function removeFile(Request $request)
    {
        dd($request->file_path);
        if(isset($request->file_path) && Storage::exists($request->file_path)){
            $this->deleteFile($request->file_path);
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.remove_file_successed'),
            ], Response::HTTP_OK);
        }
        return response()->json([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => trans('message.remove_file_failed'),
        ], Response::HTTP_NOT_FOUND);
    }
}
