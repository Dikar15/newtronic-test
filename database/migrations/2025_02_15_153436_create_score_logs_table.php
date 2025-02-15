<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('score_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('team_name');
            $table->integer('last_score');
            $table->integer('score_change');
            $table->integer('new_score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('score_logs');
    }
};
