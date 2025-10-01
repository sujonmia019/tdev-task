<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Trait UploadAble
 * @package App\Traits
 */
trait UploadAble
{

    /**
     * * Upload File Method * *
     * @param UploadedFile $file
     * @param null $folder
     * @param null $filename
     * @param null $disk
     * @return false|string
     */
    public function uploadFile($file, $folder, $disk = 'public') {
        $filenameWithExt = $file->getClientOriginalName();
        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension       = strtolower($file->getClientOriginalExtension());

        $fileName = str_replace(' ', '-', $filename).'-'.rand(111111,999999).'.'.$extension;
        $filePath = $folder.'/'.$fileName;
        Storage::disk($disk)->put($filePath, file_get_contents($file));
        return $filePath;
    }

    /**
     * ! Delete File Method !
     * @param string $filename
     * @param string $folder
     * @param string $disk
     * @return true|false
     */
    public function deleteFile($path, $disk = 'public'){
        if(!empty($path)){
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
