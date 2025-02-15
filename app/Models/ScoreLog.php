<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreLog extends Model
{
    protected $fillable = [
        'game_id',
        'team_name',
        'last_score',
        'score_change',
        'new_score'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

