<?php

namespace App\Http\Controllers;


use App\Models\File;

class FileController extends Controller
{
    public function index()
    {
        return view('dashboard.homepage', [
            'files' => File::with('user')->where('is_public', 1)->orderBy('created_at', 'asc')->get()
        ]);
    }

    public function userFiles()
    {
        return view('dashboard.user-files-page', [
            'files' => File::where('user_id', auth()->user()->id)->orderBy('created_at', 'asc')->get()
        ]);
    }

}
