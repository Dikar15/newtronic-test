<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['game_id', 'team1_score', 'team2_score'];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function updateScore($gameId, $teamName, $score)
    {
        $game = $this->where('game_id', $gameId)->first();
        // echo($game->game->team1);
        // echo($game->game->team2);
        // echo($game->team1_score);
        if ($game) {
            // Ambil skor sebelumnya dan tambahkan dengan skor baru
            if ($game->game->team1 == $teamName) {
                $lastScore = $game->team1_score;
                $game->team1_score += $score;
                $scoreUpdate = $game->team1_score;
            } elseif ($game->game->team2 == $teamName) {
                $lastScore = $game->team2_score;
                $game->team2_score += $score;
                $scoreUpdate = $game->team2_score;
            } else {
                return false; // Nama tim tidak ditemukan
            }
            // echo ($game->team1_score);
            $game->save();

            ScoreLog::create([
                'game_id' => $gameId,
                'team_name' => $teamName,
                'last_score' => $lastScore,
                'score_change' => $score,
                'new_score' => $scoreUpdate,
            ]);

            //Broadcast event untuk real-time update
            event(new \App\Events\ScoreUpdated($gameId, $teamName, $scoreUpdate));
            return true;
        }

        return false; // Game not found
    }
}
