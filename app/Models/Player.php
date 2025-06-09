<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
        'birth_date',
        'birth_place',
        'nationality',
        'position',
        'shirt_number',
        'photo',
        'height',
        'weight',
        'preferred_foot',
        'biography',
        'is_active',
        'goals',
        'assists',
        'yellow_cards',
        'red_cards'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'height' => 'integer',
        'weight' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Get the teams that the player belongs to.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->withPivot(['joined_date', 'left_date', 'contract_type', 'shirt_number'])
            ->withTimestamps();
    }

    /**
     * Get the events for the player.
     */
    public function events(): HasMany
    {
        return $this->hasMany(MatchEvent::class);
    }

    public function assists()
    {
        return $this->hasMany(MatchEvent::class, 'assist_player_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getNameAttribute()
    {
        return $this->full_name;
    }
} 