<?php

namespace App\Services;

use App\Mail\Send_Welcome_Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FileServices
{

    public function uploadImage($image, $folder)
    {



        $realName = $image->getClientOriginalName();

        $imageExtention = $image->getClientOriginalExtension();

        $completeFileName = $realName . '_' . time() . '.' . $imageExtention;

        $storeImagePath = $image->storeAs($folder, $completeFileName, 'images');

        if (!$storeImagePath) {

            return false;
        } else {

            return $storeImagePath;
        }
    }



    public static function uploadMultipleImages( $images, $folder)
    {
        try {

            $imagesPaths = [];

            foreach ($images as $image) {

                if (!$image->isValid()) {
                    throw new \Exception('Invalid image file');
                }


                $realName = $image->getClientOriginalName();
                $imageExtension = $image->getClientOriginalExtension();
                $completeFileName = $realName . '_' . time() . '.' . $imageExtension;

                $imagesPaths[] = $image->storeAs($folder, $completeFileName, 'images');
            }

            return $imagesPaths;

        } catch (\Exception $e) {

            Log::channel('seller')->error('Error uploading images: ' , [
                'exeption' => $e->getMessage()]);
            return false;
        }
    }


    public static function deleteImage($path)
    {

        if (Storage::exists($path)) {

            Storage::delete($path);

            return true;
        } else {

            return false;
        }
    }


    public static function deleteMultiImages($productImages)
    {


        foreach ($productImages as $image) {

            $originalPath = 'public/' . $image->path;
            
            Storage::delete($originalPath);
        }
    }
}
