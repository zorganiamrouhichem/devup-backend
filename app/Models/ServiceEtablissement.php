<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceEtablissement extends Model
{
    use HasFactory;

    // Si le nom de la table est différent de la convention de Laravel, vous pouvez le spécifier
    protected $table = 'service_etablissement';

    protected $fillable = [
        'nom',
        'id_etablissement',
        
    ];

    /**
     * Relation : Un service appartient à un établissement.
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'id_etablissement');
    }
}
