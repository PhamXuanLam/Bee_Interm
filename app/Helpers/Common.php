<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\returnArgument;

class Common
{
    public static function uploadImage($id, $path, $file, $oldFile = null)
    {
        $fileName = time() . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        if (!empty($oldFile)) {
            Storage::delete($path . $id . '/' . $oldFile);
        }
        $newFilePath = $path . $id . "/" . $fileName;
        $directory = dirname($newFilePath);

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }
        Storage::put($newFilePath, file_get_contents($file));

        return $fileName;
    }

    public static function showImage($path, $fileName, $default)
    {
        $imgDir = $path . $fileName;
        if (!Storage::exists($imgDir)) {
            return response()->file($default);
        }

        return Storage::response($imgDir);
    }
}
