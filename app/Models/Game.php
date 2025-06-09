<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'league_id',
        'home_team_id',
        'away_team_id',
        'match_date',
        'stadium',
        'referee',
        'home_score',
        'away_score',
        'status',
        'round',
        'season',
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'home_score' => 'integer',
        'away_score' => 'integer',
    ];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function events()
    {
        return $this->hasMany(MatchEvent::class);
    }

    public function getScoreAttribute()
    {
        if ($this->home_score === null || $this->away_score === null) {
            return 'vs';
        }
        return "{$this->home_score} - {$this->away_score}";
    }
} 