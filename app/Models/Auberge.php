<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auberge extends Model
{
    use HasFactory;
    protected $table = 'auberge';

    // Spécifie les champs qui peuvent être massivement assignés
    protected $fillable = [
        'nom',
        'capacite',
        'etat',
        'service',
        'lieu',
        'id_admin', // Ajoute id_admin comme champ assignable en masse
    ];

    /**
     * Relation : Une auberge appartient à un administrateur (User)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin'); // Spécifie la relation "appartient à" avec la table 'users'
    }
}

