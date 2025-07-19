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

    public function Upload_Image($image, $folder, $guard)
    {



        $realName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

        $imageExtention = $image->getClientOriginalExtension();

        $completeFileName = $realName . '_' . time() . '.' . $imageExtention;

        $storeImage = $image->storeAs($folder, $completeFileName, 'images');


        $status = Auth::guard($guard)->user()->update(['profile_picture' => $storeImage]);

        if (!$storeImage || !$status) {

            return false;
        } else {

            return true;
        }
    }



    public static function uploadMultipleImages($table, $foreignId, $id, $images, $folder)
    {
        try {
            DB::beginTransaction();

            foreach ($images as $image) {

                if (!$image->isValid()) {
                    throw new \Exception('Invalid image file');
                }


                $realName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageExtension = $image->getClientOriginalExtension();
                $completeFileName = $realName . '_' . time() . '.' . $imageExtension;

                // تخزين الصورة
                $storedImagePath = $image->storeAs($folder, $completeFileName, 'images');

                // إدخال البيانات في قاعدة البيانات
                DB::table($table)->insert([
                    'path' => $storedImagePath,
                    $foreignId => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('seller')->error('Error uploading images: ' , ['exeption' => $e->getMessage()]);
            return false;
        }
    }


    public static function delete_Image($guard)
    {



        $originalPath = 'public/' . Auth::guard($guard)->user()->profile_picture;
        $cleanPath = preg_replace('/[^A-Za-z0-9\-_.\/]/', '', $originalPath);


        //dd($cleanPath);
        if (Storage::exists($cleanPath)) {

            Storage::delete($cleanPath);

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
