<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoLieuTouristique extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'url',
        'id_lieu_touristique',
    ];

    /**
     * Relation : Une photo appartient à un lieu touristique
     */
    public function lieuTouristique()
    {
        return $this->belongsTo(LieuTouristique::class, 'id_lieu_touristique');
    }
}
