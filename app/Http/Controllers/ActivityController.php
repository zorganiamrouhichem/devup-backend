<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all(); // Récupérer toutes les activités
        return response()->json($activities, 200); // Retourner les activités en JSON
    }
}
