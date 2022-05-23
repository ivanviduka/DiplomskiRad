<?php

namespace App\Http\Controllers;

use App\Actions\DatabaseAction;
use App\Http\Requests\EmailRequest;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PrivateFileController extends Controller
{
    public function showSharePrivateFileForm(File $file)
    {
        $existingShares = DB::table('share_private_files')->select('id', 'receiver_email')->where('generated_file_name', $file->generated_file_name)->paginate(10);

        return view('dashboard.share-private-file-page', [
            'file' => $file,
            'existingShares' => $existingShares
        ]);
    }

    public function sendPrivateDownloadEmail(File $file, EmailRequest $request, DatabaseAction $action)
    {
        if ($action->fileNotSharedWithThisUser($file, $request)) {
            DB::table('share_private_files')->insert([
                'generated_file_name' => $file->generated_file_name,
                'sender_email' => auth()->user()->email,
                'receiver_email' => $request->email,
            ]);

            Mail::send('email.private-file-share-email', ['sender_email' => auth()->user()->email, 'file' => $file,
                'receiver_email' => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Download link for private file');
            });

            return redirect()->route('user.files')->with('message', 'Email with download link has been sent!');
        } else {
            return redirect()->route('user.files')->with('message', 'This file is already shared with selected user!');
        }

    }

    public function downloadPrivateFile(File $file, string $receiver_email)
    {
        $privateFile = DB::table('share_private_files')->select('*')->where('generated_file_name', $file->generated_file_name)
            ->where('receiver_email', $receiver_email)->first();

        if (isset($privateFile)) {
            $download_link = storage_path('app/user-files/' . basename($file->generated_file_name));
            if (file_exists($download_link)) {
                return response()->download($download_link);
            }
        } else {
            abort(404, "File not found");
        }

    }

    public function deleteShare(int $id)
    {
        $link = DB::table('share_private_files')->select('*')->where('id', $id);

        if ($link->first()->sender_email == auth()->user()->email) {
            $link->delete();
        } else {
            abort(403, 'Forbidden Access');
        }

        return redirect()->back();
    }
}
