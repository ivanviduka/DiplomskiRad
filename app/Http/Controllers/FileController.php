<?php

namespace App\Http\Controllers;

use App\Actions\FileAction;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Models\Subject;


class FileController extends Controller
{
    public function index()
    {
        return view('dashboard.homepage', [
            'files' => File::with('user:id,email', 'subject:id,subject_name')->where('is_public', 1)
                ->orderBy('created_at', 'ASC')->paginate(10)
        ]);
    }

    public function userFiles()
    {
        return view('dashboard.user-files-page', [
            'files' => File::with('subject:id,subject_name')->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'ASC')->paginate(10)
        ]);
    }

    public function createForm() {

        return view('dashboard.create-file-page', [
            'subjects' => Subject::select('id', 'subject_name')
                ->orderBy('year_of_study', 'ASC')
                ->orderBy('subject_name')->get()
        ]);
    }

    public function addFile(UploadFileRequest $request, FileAction $action){

        $fileInfo = $action->saveFile($request, 'user-files');

        File::create([
            'generated_file_name' => $fileInfo['generated_name'],
            'user_file_name' => $fileInfo['original_name'],
            'is_public' => $request->has('is_public'),
            'file_type' => $fileInfo['file_extension'],
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('user.files');
    }

    public function updateForm(File $file){

        return view('dashboard.update-file-page', [
            'file' => $file,
            'subjects' => Subject::select('id', 'subject_name')
                ->orderBy('year_of_study', 'ASC')
                ->orderBy('subject_name')->get()
        ]);
    }

    public function updateFile(UpdateFileRequest $request, File $file){

        File::where('id', $file->id)->update([
            'user_file_name' => $request->user_file_name,
            'is_public' => $request->has('is_public'),
            'description' => $request->description,
        ]);

        return redirect()->route('user.files');
    }

    public function deleteFile(File $file, FileAction $action){

        $action->deleteFile($file, 'user-files');

        File::where('id', $file->id)->delete();

        return redirect()->back();
    }

}
