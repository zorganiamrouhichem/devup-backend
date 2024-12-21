<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';

    // Définir les champs massivement assignables
    protected $fillable = [
        'id_user',
        'id_etablissement',
        'rate',
        'commentaire',
    ];

    /**
     * Relation : Une revue appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relation : Une revue appartient à un établissement
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'id_etablissement');
    }
}
