<?php

namespace App\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadPhotoService
{
    /**
     * @param UploadedFile|array $img
     * @param bool $multiple
     * @return string
     */
    public function upload(UploadedFile|array $img, bool $multiple = false): string
    {
        if($multiple) {
            $imgArray = [];

            foreach($img as $i) {
                $path = Storage::putFile('public', $i);
                $imgArray[] = Storage::url($path);
            }

            return serialize($imgArray);
        }

        $path = Storage::putFile('public', $img);
        return Storage::url($path);
    }
}
