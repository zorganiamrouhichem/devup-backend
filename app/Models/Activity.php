<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activities';


    // Définir les champs massivement assignables
    protected $fillable = [
        'nom', // Le nom de l'activité
    ];
    public function etablissements()
    {
        return $this->hasMany(Etablissement::class);
    }
}
