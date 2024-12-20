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
        // Récupérer tous les établissements avec leur activité, réservations, et services
        $etablissements = Etablissement::with(['activity', 'reservations', 'services', 'photos'])->get();


        return response()->json($etablissements,  200);
    }

    /**
     * Afficher les détails d'un établissement spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    // Récupérer l'établissement par son ID, avec l'activité, les réservations, les services, et les photos
    $etablissement = Etablissement::with(['activity', 'reservations', 'services', 'photos'])->find($id);

    if (!$etablissement) {
        return response()->json(['message' => 'Etablissement not found'], 404);
    }

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
        'abonnes' => 'required|integer',
        'lieu' => 'required|string|max:255',
        'localisation' => 'required|string|max:255',
        'photos' => 'required|array', // L'image doit être un tableau de fichiers
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation des fichiers image
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
        'abonnes' => $validated['abonnes'],
        'lieu' => $validated['lieu'],
        'localisation' => $validated['localisation'],
        'activity_id' => $activity->id, // Associer l'activité à l'établissement
    ]);

    // Traitement des photos : Upload des images
    if ($request->hasFile('photos')) {
        $photos = $request->file('photos');
        
        foreach ($photos as $photo) {
            // Stocker l'image dans le dossier 'public/photos' et obtenir le chemin
            $path = $photo->store('photos', 'public');
            
            // Créer une entrée dans la table PhotoEtablissement
            PhotoEtablissement::create([
                'url' => $path, // Enregistrer le chemin relatif de l'image
                'id_etablissement' => $etablissement->id,
            ]);
        }
    }

    // Charger la relation 'photos' après la création de l'établissement
    $etablissement->load('photos');

    // Retourner la réponse avec l'établissement, l'activité et les photos
    return response()->json([
        'message' => 'Etablissement and Activity created successfully with photos',
        'etablissement' => $etablissement,
        'activity' => $activity,
        'photos' => $etablissement->photos, // Inclure les photos ici
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
            'abonnes' => 'required|integer',
            'lieu' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
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
