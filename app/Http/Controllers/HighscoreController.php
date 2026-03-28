<?php

namespace App\Http\Controllers;

use App\Models\Highscore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HighscoreController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game'  => 'required|string|max:50',
            'score' => 'required|integer|min:1',
        ]);

        Highscore::create([
            'user_id' => Auth::id(),
            'game'    => $validated['game'],
            'score'   => $validated['score'],
        ]);

        return response()->json(['success' => true]);
    }
}
