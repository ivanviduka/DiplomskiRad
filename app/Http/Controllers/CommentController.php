<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{

    public function createComment(CreateCommentRequest $request)
    {
        Comment::create([
            'comment_text' => $request->comment,
            'file_id' => $request->file_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function deleteComment(Comment $comment)
    {
        Comment::where('id', $comment->id)->delete();
        return redirect()->back();
    }
}
