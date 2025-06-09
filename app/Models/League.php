<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'level',
        'is_active',
    ];

    /**
     * Get the teams in the league.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get the matches in the league.
     */
    public function matches(): HasMany
    {
        return $this->hasMany(Game::class);
    }
} 