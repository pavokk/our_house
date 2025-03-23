<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request)
    {
        $like = Like::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'comment_id' => $request->comment_id,
        ]);

        return response()->json(['message' => 'Like added successfully', 'like' => $like], 201);
    }

    public function destroy(Like $like)
    {
        //
    }
}
