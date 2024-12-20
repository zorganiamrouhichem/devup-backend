<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'NCN',
        'flag_parent',
        'numero_chambre',
        'date_entre',
        'date_sortie',
        'type_reserve',
        'id_auberge',
    ];

    /**
     * Relation : Un résident appartient à une auberge
     */
    public function auberge()
    {
        return $this->belongsTo(Auberge::class, 'id_auberge');
    }
}
