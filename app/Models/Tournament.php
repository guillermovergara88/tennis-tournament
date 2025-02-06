<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'winner_id',
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_tournament');
    }

    public function winner()
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }
}
