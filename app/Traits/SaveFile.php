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

        // Generate a clean filename and return a web-accessible relative path
        $filename = uniqid() . '.' . $file->extension();

        if ($path === '' || $path === null) {
            // Default directory under public
            $destination = 'images';
        } else {
            // Custom subdirectory under public
            $destination = trim($path, '/');
        }

        // Ensure the directory exists
        $publicDestination = public_path($destination);
        if (!File::exists($publicDestination)) {
            File::makeDirectory($publicDestination, 0755, true);
        }

        // Move the file into the destination directory
        $file->move($publicDestination, $filename);

        // Return the relative path to be used with asset()
        return $destination . '/' . $filename;
    }


}