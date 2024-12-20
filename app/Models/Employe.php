<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'grade',
        'emploi',
        'auberge_id',
    ];

    /**
     * Relation : Un employé appartient à une auberge
     */
    public function auberge()
    {
        return $this->belongsTo(Auberge::class, 'auberge_id');
    }
}
