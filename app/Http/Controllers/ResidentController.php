<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
    /**
     * Créer un résident.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'NCN' => 'required|integer|unique:resident,NCN',
            'flag_parent' => 'required|boolean',
            'numero_chambre' => 'required|integer',
            'date_entre' => 'required|date',
            'date_sorti' => 'nullable|date',
            'type_reserve' => 'required|string|max:255',
            'id_auberge' => 'required|integer',
        ]);

        try {
            // Créer un résident
            $resident = Resident::create($validated);

            // Retourner la réponse avec les informations du résident
            return response()->json([
                'message' => 'Resident created successfully',
                'resident' => $resident
            ], 201);
        } catch (\Exception $e) {
            // Retourner l'erreur
            return response()->json([
                'message' => 'Error occurred while creating resident',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lister tous les résidents.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer tous les résidents
        $residents = Resident::all();
        
        return response()->json($residents, 200);
    }

    /**
     * Afficher un résident spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Récupérer le résident par son ID
        $resident = Resident::find($id);

        if (!$resident) {
            return response()->json(['message' => 'Resident not found'], 404);
        }

        return response()->json($resident, 200);
    }

    /**
     * Mettre à jour les informations d'un résident.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'sexe' => 'required|in:Homme,Femme',
            'NCN' => 'required|string|max:20|unique:residents,NCN,' . $id,
            'flag_parent' => 'required|boolean',
            'numero_chambre' => 'required|integer',
            'date_entre' => 'required|date',
            'date_sorti' => 'nullable|date',
            'type_reserve' => 'required|string|max:255',
            'id_auberge' => 'required|integer',
        ]);

        // Récupérer le résident par son ID
        $resident = Resident::find($id);

        if (!$resident) {
            return response()->json(['message' => 'Resident not found'], 404);
        }

        // Mettre à jour les informations du résident
        $resident->update($validated);

        return response()->json([
            'message' => 'Resident updated successfully',
            'resident' => $resident
        ], 200);
    }

    /**
     * Supprimer un résident spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Récupérer le résident par son ID
        $resident = Resident::find($id);

        if (!$resident) {
            return response()->json(['message' => 'Resident not found'], 404);
        }

        // Supprimer le résident
        $resident->delete();

        return response()->json([
            'message' => 'Resident deleted successfully'
        ], 200);
    }
}
