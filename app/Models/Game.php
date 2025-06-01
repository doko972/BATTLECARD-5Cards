<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'player1_id',
        'player2_id',
        'winner_id',
        'current_turn',
        'turn_number',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'current_turn' => 'integer',
        'turn_number' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    // Relations
    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player2_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function gameDecks()
    {
        return $this->hasMany(GameDeck::class);
    }

    // Méthodes utiles
    public function isWaiting()
    {
        return $this->status === 'waiting';
    }

    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }

    public function getCurrentPlayer()
    {
        return $this->current_turn === 1 ? $this->player1 : $this->player2;
    }

    public function getOpponentPlayer()
    {
        return $this->current_turn === 1 ? $this->player2 : $this->player1;
    }
}