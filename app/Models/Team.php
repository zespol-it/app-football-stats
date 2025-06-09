<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'logo',
        'stadium_name',
        'stadium_capacity',
        'city',
        'country',
        'founded_year',
        'description',
        'primary_color',
        'secondary_color',
        'is_active',
        'league_id',
    ];

    /**
     * Get the league that the team belongs to.
     */
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    /**
     * Get the players for the team.
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)
            ->withPivot(['joined_date', 'left_date', 'contract_type', 'shirt_number'])
            ->withTimestamps();
    }

    /**
     * Get the home matches for the team.
     */
    public function homeMatches(): HasMany
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    /**
     * Get the away matches for the team.
     */
    public function awayMatches(): HasMany
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    /**
     * Get all matches for the team (as Eloquent relationship).
     */
    public function matches()
    {
        return $this->hasMany(Game::class, 'home_team_id')
            ->orWhere('away_team_id', $this->id);
    }
} 