<?php

namespace App\Http\Controllers;

use App\Actions\FileAction;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\Comment;
use App\Models\File;
use App\Models\Subject;
use Illuminate\Http\Request;


class FileController extends Controller
{
    public function index(Request $request, FileAction $action)
    {
        return view('dashboard.homepage', [
            'files' => $action->sortFilesForDisplay($request)
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

    public function showDetails(File $file, FileAction $action)
    {
        $details = $action->getFileDetails($file->id);

        $comments = Comment::with('user:id,first_name,last_name')
            ->where('file_id', $file->id)
            ->get();

        return view('dashboard.details', [
            'details' => $details,
            'comments' => $comments
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
            'file_size' => $fileInfo['file_size'],
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('user.files');
    }

    public function updateForm(File $file)
    {
        $subjects = Subject::select('id', 'subject_name')
            ->orderBy('year_of_study', 'ASC')
            ->orderBy('subject_name')->get();

        return view('dashboard.update-file-page', [
            'file' => $file,
            'subjects' => $subjects
        ]);
    }

    public function updateFile(UpdateFileRequest $request, File $file)
    {
        $file->update([
            'user_file_name' => $request->user_file_name,
            'is_public' => $request->has('is_public'),
            'description' => $request->description,
            'subject_id' => $request->subject_id
        ]);

        return redirect()->route('user.files');
    }

    public function deleteFile(File $file, FileAction $action)
    {
        $action->deleteFile($file, 'user-files');

        $file->delete();

        return redirect()->back();
    }

    public function downloadFile(File $file)
    {
        $download_link = storage_path('app/user-files/' . basename($file->generated_file_name));

        if (file_exists($download_link)) {
            return response()->download($download_link);
        }
    }

    public function likeFile(File $file)
    {
        $file->like();
        $file->save();

        return redirect()->back();
    }

    public function unlikeFile(File $file)
    {
        $file->unlike();
        $file->save();

        return redirect()->back();
    }

}
