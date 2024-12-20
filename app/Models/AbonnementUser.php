<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbonnementUser extends Model
{
    use HasFactory;
    protected $table = 'abonnement_user';

    // Définir les champs massivement assignables
    protected $fillable = [
        'id_user', // ID de l'utilisateur
        'id_etablissement', // ID de l'établissement
    ];

    /**
     * Relation : Un abonnement appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relation : Un abonnement appartient à un établissement
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'id_etablissement');
    }
}
