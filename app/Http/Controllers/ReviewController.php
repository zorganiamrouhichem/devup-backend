<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($id_etablissement)
    {
        // Récupérer les avis pour l'établissement spécifique
        $reviews = Review::where('id_etablissement', $id_etablissement)->with(['user'])->get();

        return response()->json($reviews, 200);
    }
    public function show($id)
    {
        // Récupérer l'avis par son ID, avec l'utilisateur et l'établissement
        $review = Review::with(['user', 'etablissement'])->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($review, 200);
    }
    public function store(Request $request)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id', // Vérifier que l'utilisateur existe
            'id_etablissement' => 'required|exists:etablissements,id', // Vérifier que l'établissement existe
            'rate' => 'required|integer|min:1|max:5', // La note doit être entre 1 et 5
            'commentaire' => 'nullable|string|max:1000', // Commentaire optionnel
        ]);

        // Créer l'avis
        $review = Review::create($validated);

        return response()->json([
            'message' => 'Review created successfully',
            'review' => $review,
        ], 201);
    }
}
