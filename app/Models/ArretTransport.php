<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArretTransport extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'lieu',
        'id_transport',
    ];

    /**
     * Relation : Un arrêt de transport appartient à un transport
     */
    public function transport()
    {
        return $this->belongsTo(Transport::class, 'id_transport');
    }
}
