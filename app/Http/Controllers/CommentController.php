<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Post;
use App\Models\Event;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:512',
            'commentable_id'   => 'required',
            'commentable_type' => 'required|string',
            'parent_id'        => 'nullable|exists:comments,id', // For replies
        ]);

        $allowedTypes = [
            'post'    => Post::class,
            'event'   => Event::class,
            // 'task'    => \App\Models\Task::class, // Add this when ready
        ];

        $typeAlias = $request->commentable_type;
        if (!array_key_exists($typeAlias, $allowedTypes)) {
            return back()->withErrors(['error' => 'Invalid target.']);
        }

        // 3. Find the parent model (Post, Event, etc.)
        $modelClass = $allowedTypes[$typeAlias];

        try {
            $parent = $modelClass::findOrFail($request->commentable_id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['error' => 'The item you are commenting on could not be found.']);
        }

        $parent->comments()->create([
            'comment'   => $request->comment,
            'user_id'   => Auth::id(),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Comment posted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // Use a Gate or Policy for this in the future,
        // but for now, just check the user ID.
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
