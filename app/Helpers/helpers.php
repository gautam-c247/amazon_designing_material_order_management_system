<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

if (!function_exists('storeImage')) {
    /**
     * Store an uploaded image with a unique name.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param string|null $disk
     * @return string|null The stored file name or null on failure
     */
    function storeImage($file, $path)
    {
        if (!$file->isValid()) {
            return null;
        }
        $uniqueName = Str::random(40) . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($path, $file, $uniqueName);
        return $uniqueName;
    }
}
if (!function_exists('deleteImage')) {
    /**
     * Delete an image associated with a model instance.
     *
     * @param string $path The path where the image is stored.
     * @param \Illuminate\Database\Eloquent\Model $modelInstance The model instance associated with the image.
     * @return void
     */

    function deleteImage($path, $modelInstance)
    {
        if ($modelInstance->media()->exists()) {
            $fileName = $modelInstance->media()->first()->name;
            Storage::delete($path . '/' . $fileName);
            $modelInstance->media()->delete();
        }
    }
}
