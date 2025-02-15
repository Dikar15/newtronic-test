<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Score;
use App\Models\ActivityLog;
use App\Events\ScoreUpdated;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function updateScore(Request $request, $gameId)
    {
        $score = Score::where('game_id', $gameId)->first();
        $score->update([
            'team1_score' => $request->team1_score,
            'team2_score' => $request->team2_score
        ]);

        // // Logging
        // ActivityLog::create([
        //     'action' => 'Update Score',
        //     'data' => json_encode($request->all())
        // ]);

        // broadcast(new ScoreUpdated($score));
        return response()->json(['success' => true]);
    }
}

