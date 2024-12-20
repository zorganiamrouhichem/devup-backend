<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'NCN',
        'id_auberge',
    ];

    /**
     * Relation : Une personne dans la black list appartient à une auberge
     */
    public function auberge()
    {
        return $this->belongsTo(Auberge::class, 'id_auberge');
    }
}
