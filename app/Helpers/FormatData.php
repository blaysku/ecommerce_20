<?php

namespace App\Helpers;

use Storage;

class FormatData
{
    public static function currency($price = 0)
    {
        return number_format($price * config('setting.currency_unit')) . ' ' . config('setting.currency');
    }

    public static function upload($request, $imageFieldName, $uploadFolder, $path = true)
    {
        if (!$request->hasFile($imageFieldName)) {
            return null;
        }

        $file = $request->file($imageFieldName);
        $fileName = $file->getClientOriginalName();

        if (Storage::exists($uploadFolder . '/' . $fileName)) {
            $fileName = md5(time()) . $fileName;
        }

        $image = $file->storeAs($uploadFolder, $fileName);

        if ($path == false) {
            return $fileName;
        }

        return $image;
    }
}
