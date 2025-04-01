<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request)
    {

        \Log::info($request->all());

        $like = Like::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'comment_id' => $request->comment_id,
        ]);

        return response()->json(['message' => 'Like added successfully', 'like' => $like], 201);
    }

    public function destroy($postId)
    {
        $like = Like::where('post_id', $postId)->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Likeremoved successfully']);
        }

        return response()->json(['message' => 'Like not found'], 404);
    }
}
