<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color', 'description', 'is_active']; // Enlever la virgule au début

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relation : un camp a plusieurs cartes
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    // Méthode pour récupérer le lieutenant du camp
    public function lieutenant()
    {
        return $this->hasOne(Card::class)->where('type', 'lieutenant');
    }

    // Méthode pour récupérer les sous-fifres
    public function sousFifres()
    {
        return $this->hasMany(Card::class)->where('type', 'sous_fifre');
    }
}