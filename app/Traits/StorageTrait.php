<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait StorageTrait
{
    /**
     * Upload file to Storage
     * @param $file
     * @param $filePath
     * @return string path of the file manage by Storage
     */
    public function uploadFile($file, $filePath) {
        // Make directory if not exist
        $directory = dirname($filePath);
        if (!Storage::disk(FILESYSTEM)->exists($directory)) {
            Storage::disk(FILESYSTEM)->makeDirectory($directory);
        }

        // Store file
        Storage::disk(FILESYSTEM)->put($filePath, file_get_contents($file));

        return $filePath;
    }

    /**
     * Upload file to Storage by stream
     * @param $stream
     * @param $filePath
     * @return string path of the file manage by Storage
     */
    public function uploadFileByStream($stream, $filePath) {
        // Make directory if not exist
        $directory = dirname($filePath);
        if (!Storage::disk(FILESYSTEM)->exists($directory)) {
            Storage::disk(FILESYSTEM)->makeDirectory($directory);
        }

        // Store file
        Storage::disk(FILESYSTEM)->put($filePath, $stream);

        return $filePath;
    }

    /**
     * Move file from original path to destination path
     *
     * @param $destinationPath
     * @param $originalPath
     */
    public function moveFile($originalPath, $destinationPath)
    {
        $size = Storage::disk(FILESYSTEM)->size($originalPath);
        $directory = dirname($destinationPath);
        if (!Storage::disk(FILESYSTEM)->exists($directory)) {
            Storage::disk(FILESYSTEM)->makeDirectory($directory);
        }

        Storage::disk(FILESYSTEM)->move($originalPath,$destinationPath);
        return $size;
    }

    /**
     * Delete file
     * @param string
     */
    public function deleteFile($filePath) {
        Storage::disk(FILESYSTEM)->delete($filePath);
    }

    /**
     * Delete directory
     * @param string
     */
    public function deleteDirectory($directoryPath) {
        Storage::disk(FILESYSTEM)->deleteDirectory($directoryPath);
    }
    /**
     * Make directory
     * @param string
     */
    public function makeDirectory($directoryPath) {
        Storage::disk(FILESYSTEM)->makeDirectory($directoryPath);
    }

    /**
     * Delete files in directory which matching with the regex
     *
     * @param $directory
     * @param $regex
     */
    public function deleteFilesMatchingRegex($directory, $regex) {
        // List all filenames in directory
        $all_files = Storage::disk(FILESYSTEM)->files($directory);

        // filter the ones that match the regex
        $matching_files = preg_grep("/$regex/", $all_files);

        // iterate through files and echo their content
        foreach ($matching_files as $path) {
            $this->deleteFile($path);
        }
    }

    /**
     * Get file from Storage
     *
     * @param Request $request
     * @return mixed
     */
    public function getFile($file_path){
        if (!Storage::disk(FILESYSTEM)->exists($file_path)) {
            return null;
        }
        return Storage::disk(FILESYSTEM)->get($file_path);
    }
}
