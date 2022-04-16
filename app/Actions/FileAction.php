<?php

namespace App\Actions;


use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileAction {

    public function saveFile(UploadFileRequest $request, string $storagePath){

        $file = $request->file('file');
        $generatedFileName = Str::uuid()->toString() . '.' . $file->extension();
        $file->storeAs($storagePath, $generatedFileName);

        return [
            'generated_name' => $generatedFileName,
            'original_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_extension' => $file->extension()];
    }

    public function deleteFile(File $file, string $storagePath){
        Storage::delete($storagePath . "/" . $file->generated_file_name);
    }

}



