<?php

namespace App\Http\Controllers;

use App\Models\Highscore;
use Illuminate\Support\Facades\DB;

class TetrisController extends Controller
{
    public function index()
    {
        $scores = Highscore::with('user')
            ->where('game', 'tetris')
            ->select('user_id', DB::raw('MAX(score) as score'))
            ->groupBy('user_id')
            ->orderByDesc('score')
            ->limit(10)
            ->get();

        return view('games.tetris', compact('scores'));
    }
}
