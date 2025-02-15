<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScoreUpdated implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameId;
    public $team;
    public $score;

    public function __construct($gameId, $team, $score) {
        $this->gameId = $gameId;
        $this->team = $team;
        $this->score = $score;
    }

    public function broadcastOn() {
        return ['game.' . $this->gameId];
    }

    public function broadcastWith() {
        return [
            'team' => $this->team,
            'score' => $this->score,
        ];
    }
}


