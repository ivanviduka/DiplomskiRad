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
        $files = File::with('user:id,email', 'subject:id,subject_name', 'likeCounter', 'likes')
            ->leftJoin('likeable_like_counters', 'files.id', '=', 'likeable_like_counters.likeable_id')
            ->select('files.*')
            ->where('is_public', 1)
            ->orderBy('likeable_like_counters.count', 'DESC')
            ->orderBy('files.user_file_name', 'ASC')->paginate(10);

        return view('dashboard.homepage', [
            'files' => $files
        ]);
    }

    public function userFiles()
    {
        return view('dashboard.user-files-page', [
            'files' => File::with('subject:id,subject_name')->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'ASC')->paginate(10)
        ]);
    }

    public function createForm()
    {
        return view('dashboard.create-file-page', [
            'subjects' => Subject::select('id', 'subject_name')
                ->orderBy('year_of_study', 'ASC')
                ->orderBy('subject_name')->get()
        ]);
    }

    public function showDetails(File $file){

        $details = File::with('user:id,first_name,last_name,email', 'subject:id,subject_name,major_name,year_of_study')
            ->where('id', $file->id)
            ->first();

        return view('dashboard.details', [
            'details' => $details
        ]);
    }

    public function addFile(UploadFileRequest $request, FileAction $action)
    {

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

    public function updateForm(File $file)
    {

        return view('dashboard.update-file-page', [
            'file' => $file,
            'subjects' => Subject::select('id', 'subject_name')
                ->orderBy('year_of_study', 'ASC')
                ->orderBy('subject_name')->get()
        ]);
    }

    public function updateFile(UpdateFileRequest $request, File $file)
    {

        File::where('id', $file->id)->update([
            'user_file_name' => $request->user_file_name,
            'is_public' => $request->has('is_public'),
            'description' => $request->description,
        ]);

        return redirect()->route('user.files');
    }

    public function deleteFile(File $file, FileAction $action)
    {

        $action->deleteFile($file, 'user-files');

        File::where('id', $file->id)->delete();

        return redirect()->back();
    }

    public function downloadFile(File $file)
    {
        $download_link = storage_path('app/user-files/' . $file->generated_file_name);
        if (file_exists($download_link)) {
            return response()->download($download_link);
        }
    }

    public function likeFile(File $file){
        $file->like();
        $file->save();

        return redirect()->back();
    }

    public function unlikeFile(File $file){
        $file->unlike();
        $file->save();

        return redirect()->back();
    }

}
