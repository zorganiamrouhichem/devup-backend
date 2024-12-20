<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LieuTouristique extends Model
{
    use HasFactory;

    // Définir les champs massivement assignables
    protected $fillable = [
        'nom',
        'lieu',
    ];
}
