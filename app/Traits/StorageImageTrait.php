<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
trait StorageImageTrait{
    public function storageTraitUpload($request, $fieldName, $folderName){
        if($request->hasFile($fieldName)){
            $file = $request->$fieldName;
        $fileNameOrgininal = $file->getClientOriginalName();
        $imageNameHash = Str::random(20).'.'.$file->getClientOriginalExtension();
        $path = $request->file($fieldName)->storeAs('public/'.$folderName.'/'.auth()->id(),$imageNameHash);
        $dataUploadTrait = [
            'fileName'=> $fileNameOrgininal,
            'filePath'=> Storage::url($path)
        ];
        return $dataUploadTrait;
        }

        return null;

    }

    public function storageTraitUploadMultiple($file, $folderName){

        $fileNameOrgininal = $file->getClientOriginalName();
        $imageNameHash = Str::random(20).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('public/'.$folderName.'/'.auth()->id(),$imageNameHash);
        $dataUploadTrait = [
            'fileName'=> $fileNameOrgininal,
            'filePath'=> Storage::url($path)
        ];
        return $dataUploadTrait;
    }



}
