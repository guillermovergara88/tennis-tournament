<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'skill',
        'strength',
        'speed',
        'reaction_time',
    ];

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'player_tournament');
    }
}
