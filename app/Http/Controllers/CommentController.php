<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:512',
        ]);

        $comment = New Comment();
        $comment->comment = $request->comment;
        $comment->user_id = auth()->id();
        $comment->post_id = $request->post_id;
        $comment->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
