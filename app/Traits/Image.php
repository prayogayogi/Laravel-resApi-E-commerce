<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * upload Image
 */
trait Image
{
    /**
     * uploadImage
     *
     * @param $request, $imageName, $directoryName
     * @return image
     */
    public function uploadImage($request, string $imageName, string $directoryName)
    {
        $image = $request->file($imageName);
        $image->storeAs($directoryName, $image->hashName());
        return $image;
    }

    /**
     * deleteImage
     * @param $request, $imageName
     * @return void
     */
    public function deleteImage(string $typepath, string $directoryName, $basename)
    {
        Storage::disk($typepath)->delete($directoryName . basename($basename));
    }
}
