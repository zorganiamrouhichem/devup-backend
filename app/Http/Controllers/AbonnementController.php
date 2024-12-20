<?php

namespace App\Http\Controllers;

use App\Models\AbonnementUser;
use App\Models\Etablissement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function subscribe(Request $request)
    {
        // Valider les données de la requête
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',  // Vérifie si l'ID de l'utilisateur existe
            'id_etablissement' => 'required|exists:etablissements,id',  // Vérifie si l'ID de l'établissement existe
        ]);
    
        // Récupérer l'ID de l'utilisateur et de l'établissement
        $user_id = $validated['user_id'];
        $etablissement_id = $validated['id_etablissement'];
    
        // Vérifier si l'utilisateur est déjà abonné à cet établissement
        $existingAbonnement = AbonnementUser::where('id_user', $user_id)
                                            ->where('id_etablissement', $etablissement_id)
                                            ->first();
    
        if ($existingAbonnement) {
            return response()->json(['message' => 'Vous êtes déjà abonné à cet établissement.'], 400);
        }
    
        // Créer un nouvel abonnement
        $abonnement = AbonnementUser::create([
            'id_user' => $user_id,
            'id_etablissement' => $etablissement_id,
        ]);
    
        // Incrémenter le nombre d'abonnés de l'établissement
        $etablissement = Etablissement::find($etablissement_id);
        $etablissement->abonnes += 1;  // Incrémenter le compteur des abonnés
        $etablissement->save();  // Sauvegarder la mise à jour
    
        // Retourner une réponse avec un message de succès
        return response()->json([
            'message' => 'Vous vous êtes abonné à l\'établissement avec succès.',
            'abonnement' => $abonnement
        ], 201);
    }
}
