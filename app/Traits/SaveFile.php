<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

trait SaveFile
{


    protected function saveImage($file, $previousImage = '', $path = '', $table = '', $id = '')
    {
        if ($table != '') {
            $image = DB::table('')->where('id', $id)->first();
            $image_path = $previousImage;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $image_name = 'images/' . uniqid() . '.' . $file->extension();

        if ($path == '') {
            $file->move(public_path('images/'), $image_name);
        } else {
            $file->move(public_path('' . $path . '/'), $image_name);
        }

        return $image_name;
    }


}
