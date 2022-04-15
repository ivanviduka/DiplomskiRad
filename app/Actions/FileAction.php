<?php

namespace App\Actions;


use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Str;

class FileAction {

    public function saveFile(UploadFileRequest $request, string $storagePath){

        $file = $request->file('file');
        $generatedFileName = Str::uuid()->toString() . '.' . $file->extension();
        $file->storeAs($storagePath, $generatedFileName);

        return [
            'generated_name' => $generatedFileName,
            'original_name' => $file->getClientOriginalName(),
            'file_extension' => $file->extension()];
    }

}



