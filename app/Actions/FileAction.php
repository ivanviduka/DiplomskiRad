<?php

namespace App\Actions;


use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class FileAction
{

    public function saveFile(UploadFileRequest $request, string $storagePath)
    {

        $file = $request->file('file');
        $generatedFileName = Str::uuid()->toString() . '.' . $file->extension();
        $file->storeAs($storagePath, $generatedFileName);

        return [
            'generated_name' => $generatedFileName,
            'original_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_extension' => $file->extension(),
            'file_size' => $file->getSize(),
        ];
    }

    public function sortFilesForDisplay(Request $request)
    {

        $sortDirection = session()->get('sortDirection', true);
        $previousPage = session()->get('previousPage', 1);

        if (!isset($request->page)) {
            $request->page = 1;
        }

        if ($previousPage == (int)$request->page) {
            $sortDirection = !$sortDirection;
            session()->put('sortDirection', $sortDirection);
        }

        $files = File::with('user:id,email', 'subject:id,subject_name', 'likeCounter', 'likes')
            ->join('users', 'files.user_id', '=', 'users.id')
            ->leftJoin('likeable_like_counters', 'files.id', '=', 'likeable_like_counters.likeable_id')
            ->select('files.*', 'users.email')
            ->where('is_public', 1);

        if (!isset($request->sort)) {
            $files->orderBy('likeable_like_counters.count', $sortDirection ? 'DESC' : 'ASC')
                ->orderBy('files.user_file_name', 'ASC');
        } else if ($request->sort == 'new') {
            $files->orderBy('created_at', $sortDirection ? 'DESC' : 'ASC')
                ->orderBy('files.user_file_name', 'ASC');
        } else if ($request->sort == 'name') {
            $files->orderBy('files.user_file_name', $sortDirection ? 'DESC' : 'ASC')
                ->orderBy('likeable_like_counters.count', 'DESC');
        } else if ($request->sort == 'size') {
            $files->orderBy('files.file_size', $sortDirection ? 'DESC' : 'ASC')
                ->orderBy('likeable_like_counters.count', 'DESC');
        } else if ($request->sort == 'owner') {
            $files->orderBy('users.email', $sortDirection ? 'DESC' : 'ASC')
                ->orderBy('likeable_like_counters.count', 'DESC');
        }

        $results = $files->paginate(10)->appends(request()->query());

       session()->put('previousPage', $results->currentPage());

       return $results;



    }

    public function getFileDetails(int $file_id)
    {
        $details = File::with('user:id,first_name,last_name,email', 'subject:id,subject_name,major_name,year_of_study')
            ->where('id', $file_id)
            ->first();

        if (isset($details)) {
            if (!$details->is_public) {
                abort(403, "This file is private");
            }
        } else {
            abort(404);
        }

        return $details;
    }

    public function deleteFile(File $file, string $storagePath)
    {

        Storage::delete($storagePath . "/" . $file->generated_file_name);
        DB::table('likeable_likes')->where('likeable_id', $file->id)->delete();
        DB::table('likeable_like_counters')->where('likeable_id', $file->id)->delete();
    }

    public function deleteUserFiles(User $user, string $storagePath)
    {

        $files = File::where("user_id", $user->id)->get();
        foreach ($files as $file) {
            $this->deleteFile($file, $storagePath);
        }

    }

}



