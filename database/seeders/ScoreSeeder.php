<?php

namespace Database\Seeders;

use App\Models\Score;
use App\Models\Game;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua game yang ada
        $games = Game::all();

        // Buat skor awal untuk setiap game
        foreach ($games as $game) {
            Score::create([
                'game_id' => $game->id,
                'team1_score' => rand(0, 5), // Nilai acak 0 - 5
                'team2_score' => rand(0, 5)
            ]);
        }
    }
}
