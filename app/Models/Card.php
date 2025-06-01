<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'hp',
        'max_hp',
        'xp',
        'attack',
        'defense',
        'speed',
        'camp_id',
        'image_path',
        'description'
    ];

    protected $casts = [
        'hp' => 'integer',
        'max_hp' => 'integer',
        'xp' => 'integer',
        'attack' => 'integer',
        'defense' => 'integer',
        'speed' => 'integer',
        'camp_id' => 'integer',
    ];

    // Relation : une carte appartient à un camp
    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    // Méthode pour vérifier si c'est un lieutenant
    public function isLieutenant()
    {
        return $this->type === 'lieutenant';
    }

    // Méthode pour vérifier si la carte est encore vivante
    public function isAlive()
    {
        return $this->hp > 0;
    }

    // Méthode pour reset les HP à la valeur max
    public function resetHp()
    {
        $this->hp = $this->max_hp;
        $this->save();
    }
}