<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use Illuminate\Http\Request;

class BlackListController extends Controller
{
    /**
     * Ajouter une personne à la liste noire.
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
            'grade' => 'nullable|string|max:255',
            'emploi' => 'nullable|string|max:255',
            'auberge_id' => 'required|int', // Clé étrangère pour l'auberge
        ]);

        try {
            // Ajouter une personne à la liste noire
            $blackList = BlackList::create($validated);

            // Retourner la réponse avec les informations de la personne ajoutée
            return response()->json([
                'message' => 'Person added to black list successfully',
                'black_list' => $blackList
            ], 201);
        } catch (\Exception $e) {
            // Retourner l'erreur
            return response()->json([
                'message' => 'Error occurred while adding to black list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lister toutes les personnes dans la liste noire.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer toutes les entrées de la liste noire
        $blackList = BlackList::all();

        return response()->json($blackList, 200);
    }

    /**
     * Afficher une entrée spécifique de la liste noire.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Récupérer l'entrée par son ID
        $blackList = BlackList::find($id);

        if (!$blackList) {
            return response()->json(['message' => 'Black list entry not found'], 404);
        }

        return response()->json($blackList, 200);
    }

    /**
     * Mettre à jour les informations d'une entrée de la liste noire.
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
            'grade' => 'nullable|string|max:255',
            'emploi' => 'nullable|string|max:255',
            'auberge_id' => 'required|exists:auberges,id',
        ]);

        // Récupérer l'entrée par son ID
        $blackList = BlackList::find($id);

        if (!$blackList) {
            return response()->json(['message' => 'Black list entry not found'], 404);
        }

        // Mettre à jour les informations
        $blackList->update($validated);

        return response()->json([
            'message' => 'Black list entry updated successfully',
            'black_list' => $blackList
        ], 200);
    }

    /**
     * Supprimer une entrée de la liste noire.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Récupérer l'entrée par son ID
        $blackList = BlackList::find($id);

        if (!$blackList) {
            return response()->json(['message' => 'Black list entry not found'], 404);
        }

        // Supprimer l'entrée
        $blackList->delete();

        return response()->json([
            'message' => 'Black list entry deleted successfully'
        ], 200);
    }
}

