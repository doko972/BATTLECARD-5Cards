<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDeck extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_id',
        'card_id',
        'position',
        'current_hp',
        'is_alive'
    ];

    protected $casts = [
        'current_hp' => 'integer',
        'is_alive' => 'boolean',
    ];

    // Relations
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    // Méthodes utiles
    public function isLieutenant()
    {
        return $this->position === 'lieutenant';
    }

    public function takeDamage($damage)
    {
        $this->current_hp = max(0, $this->current_hp - $damage);
        if ($this->current_hp <= 0) {
            $this->is_alive = false;
        }
        $this->save();
    }

    public function resetHp()
    {
        $this->current_hp = $this->card->max_hp;
        $this->is_alive = true;
        $this->save();
    }
}