<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'nom',
        'type',
        'description',
        'capacite',
        'abonnes',
        'lieu',
        'localisation',
        'activity_id',
    ];
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id'); // L'établissement appartient à une activité via l'ID de l'activité
    }
    public function reservations()
{
    return $this->hasMany(Reservation::class);
}
public function services()
{
    return $this->hasMany(ServiceEtablissement::class);
}
public function photos()
{
    return $this->hasMany(PhotoEtablissement::class);
}
}
