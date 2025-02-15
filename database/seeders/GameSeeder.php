<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run()
    {
        // Contoh beberapa jenis olahraga
        $games = [
            [
                'sport' => 'Sepak Bola',
                'team1' => 'Tim Garuda',
                'team2' => 'Tim Macan'
            ],
            [
                'sport' => 'Basket',
                'team1' => 'Tim Elang',
                'team2' => 'Tim Naga'
            ],
            [
                'sport' => 'Voli',
                'team1' => 'Tim Petir',
                'team2' => 'Tim Ombak'
            ]
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
