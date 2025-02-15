<?php

namespace App\Http\Controllers;

use App\Events\ScoreUpdated;
use App\Models\Score;
use App\Models\Game;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ScoreController extends Controller
{
    public function showOperator()
    {
        $games = Game::with('score')->get();
        return view('/scoreboard/operator', compact('games'));
    }

    public function showScoreboard()
    {
        $games = Game::with('score')->get();
        return view('/scoreboard/scoreboard', compact('games'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|integer',
            'team_name' => 'required|string',
            'score' => 'required|integer',
        ]);

        

        $gameId = $validated['game_id'];
        $teamName = $validated['team_name'];
        $score = $validated['score'];

        $scoreModel = new Score();
        $result = $scoreModel->updateScore($gameId, $teamName, $score);
        // echo($gameId);
        // echo($teamName);
        // echo($score);

        if ($result) {
            return response()->json(['message' => 'Score updated successfully.']);
        } else {
            return response()->json(['message' => 'Failed to update score.'], 400);
        }
    }
}
