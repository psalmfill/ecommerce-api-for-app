<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    public function uploadSingleFile($path, $file)
    {
        $uploadPath = Storage::putFile('public/' . $path, $file);

        return $uploadPath;
    }

    public function uploadMultipleFiles($path, $files)
    {
        $filePaths = [];
        foreach ($files as $file) {
            array_push($filePaths, $this->uploadSingleFile($path, $file));
        }

        return $filePaths;
    }

    public function removeFile($path)
    {
        if (Storage::exists($path)) {
            return Storage::delete($path);
        }
    }

    public function removeMultipleFiles($paths)
    {
        foreach ($paths as $path) {
            $this->removeFile($path);
        }
        return true;
    }
}
