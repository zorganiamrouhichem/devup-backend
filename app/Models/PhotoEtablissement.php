<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoEtablissement extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'url',
        'id_etablissement',
    ];

    /**
     * Relation : Une photo appartient à un établissement
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'id_etablissement');
    }
}
