<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('match_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('matches')->onDelete('cascade');
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->string('event_type'); // goal, yellow_card, red_card, substitution, etc.
            $table->integer('minute');
            $table->string('description')->nullable();
            $table->foreignId('assist_player_id')->nullable()->constrained('players')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('match_events');
    }
}; 