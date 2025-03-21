<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $users = User::all()->keyBy('id')->toArray();
        $title = 'Skagesundvegen 63';

        return view('post.index', compact('posts', 'users', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:512',
            'type' => 'nullable|string|max:10',
            'image' => 'nullable|image|max:10240'
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->type = $request->type;
        $post->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/posts', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('index')->with('success', 'Post created!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }
}
