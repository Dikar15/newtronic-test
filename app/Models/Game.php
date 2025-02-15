<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['sport', 'team1', 'team2'];

    public function score()
    {
        return $this->hasOne(Score::class);
    }
}
