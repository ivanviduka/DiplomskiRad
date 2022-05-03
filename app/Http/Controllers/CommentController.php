<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\File;

class CommentController extends Controller
{
    public function createComment(CreateCommentRequest $request)
    {
        if(!File::find($request->file_id)->is_public){
            redirect()->back()->withErrors(['not_public' => 'Cannot submit comment']);
        }

        Comment::create([
            'comment_text' => $request->comment,
            'file_id' => $request->file_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
