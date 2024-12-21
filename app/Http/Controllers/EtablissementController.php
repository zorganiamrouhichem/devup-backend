<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\PhotoEtablissement;

class EtablissementController extends Controller
{
    /**
     * Afficher tous les établissements.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer tous les établissements avec leur image par défaut ou la première photo
        $etablissements = Etablissement::all();
    
        // Parcourir chaque établi
    
        // Retourner la réponse avec un code 200
        return response()->json($etablissements, 200);
    }


    /**
     * Afficher les détails d'un établissement spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    // Récupérer l'établissement par son ID, sans ses relations
    $etablissement = Etablissement::find($id);

    if (!$etablissement) {
        return response()->json(['message' => 'Etablissement not found'], 404);
    }

    // Retourner uniquement l'établissement sans ses relations
    return response()->json($etablissement, 200);
}

    /**
     * Créer un nouvel établissement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'activity_nom' => 'required|string|max:255',
            'etablissement_nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'capacite' => 'required|integer',
            'lieu' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'Prix_nuit' => 'required|numeric',
            'urldefaultimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Validation pour l'image par défaut
        ]);
    
        // Créer l'activité associée à l'établissement
        $activity = Activity::create([
            'nom' => $validated['activity_nom'],
        ]);
    
        // Créer l'établissement
        $etablissement = Etablissement::create([
            'nom' => $validated['etablissement_nom'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'capacite' => $validated['capacite'],
            'lieu' => $validated['lieu'],
            'localisation' => $validated['localisation'],
            'Prix_nuit' => $validated['Prix_nuit'],
            'activity_id' => $activity->id, // Associer l'activité à l'établissement
        ]);
    
        // Traitement de l'image par défaut
        if ($request->hasFile('urldefaultimage')) {
            $defaultImage = $request->file('urldefaultimage');
    
            // Stocker l'image par défaut dans le dossier 'public/images' et obtenir le chemin
            $defaultImagePath = $defaultImage->store('images', 'public');
    
            // Mettre à jour l'établissement avec le chemin de l'image par défaut
            $etablissement->urldefaultimage = $defaultImagePath;
            $etablissement->save(); // Sauvegarder l'établissement avec l'URL de l'image par défaut
        }
    
        // Retourner la réponse avec l'établissement, l'activité, et les photos
        return response()->json([
            'message' => 'Etablissement and Activity created successfully with default image',
            'etablissement' => $etablissement,  // Retourner l'établissement avec le chemin de l'image par défaut
            'activity' => $activity,
        ], 201);
    }
    

    
    /**
     * Mettre à jour les informations d'un établissement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'capacite' => 'required|integer',
            'lieu' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'Prix_nuit' => 'required|float',
            'activity_id' => 'required|exists:activities,id', // Vérifier que l'ID de l'activité existe
        ]);

        // Récupérer l'établissement
        $etablissement = Etablissement::find($id);

        if (!$etablissement) {
            return response()->json(['message' => 'Etablissement not found'], 404);
        }

        // Mettre à jour les informations de l'établissement
        $etablissement->update($validated);

        return response()->json([
            'message' => 'Etablissement updated successfully',
            'etablissement' => $etablissement
        ], 200);
    }

    /**
     * Supprimer un établissement.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Récupérer l'établissement par son ID
        $etablissement = Etablissement::find($id);

        if (!$etablissement) {
            return response()->json(['message' => 'Etablissement not found'], 404);
        }

        // Supprimer l'établissement
        $etablissement->delete();

        return response()->json([
            'message' => 'Etablissement deleted successfully'
        ], 200);
    }
}
