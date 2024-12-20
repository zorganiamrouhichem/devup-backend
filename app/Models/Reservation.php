<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'id_user',
        'id_etablissement',
        'nombre',
        'date_debut',
        'date_fin',
    ];

    /**
     * Relation : Une réservation appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relation : Une réservation appartient à un établissement
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'id_etablissement');
    }
}
