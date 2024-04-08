<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
trait DeleteImageTrait{
    public function deleteImage($folderName, $imagePath){
        $path = 'public/'.$folderName.'/'.auth()->id();
        if ($imagePath != null) {
           if ( unlink($path.$imagePath)) {
            return true;
           }
           return false;
        }


    }





}
