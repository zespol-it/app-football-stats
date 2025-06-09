<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_id',
        'team_id',
        'event_type',
        'minute',
        'description',
        'assist_player_id',
    ];

    protected $casts = [
        'minute' => 'integer',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function assistPlayer()
    {
        return $this->belongsTo(Player::class, 'assist_player_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
} 