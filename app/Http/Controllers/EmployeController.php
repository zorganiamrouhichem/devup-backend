<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeController extends Controller
{
    /**
     * Créer un employé.
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
            'grade' => 'required|string|max:255',
            'emploi' => 'required|string|max:255',
            'auberge_id' => 'required|exists:auberge,id', // Clé étrangère pour l'auberge
        ]);

        try {
            // Créer un employé
            $employe = Employe::create($validated);

            // Retourner la réponse avec les informations de l'employé
            return response()->json([
                'message' => 'Employe created successfully',
                'employe' => $employe
            ], 201);
        } catch (\Exception $e) {
            // Retourner l'erreur
            return response()->json([
                'message' => 'Error occurred while creating employe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lister tous les employés.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer tous les employés
        $employes = Employe::all();

        return response()->json($employes, 200);
    }

    /**
     * Afficher un employé spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Récupérer l'employé par son ID
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'Employe not found'], 404);
        }

        return response()->json($employe, 200);
    }

    /**
     * Mettre à jour les informations d'un employé.
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
            'grade' => 'required|string|max:255',
            'emploi' => 'required|string|max:255',
            'auberge_id' => 'required|exists:auberges,id',
        ]);

        // Récupérer l'employé par son ID
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'Employe not found'], 404);
        }

        // Mettre à jour les informations de l'employé
        $employe->update($validated);

        return response()->json([
            'message' => 'Employe updated successfully',
            'employe' => $employe
        ], 200);
    }

    /**
     * Supprimer un employé spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Récupérer l'employé par son ID
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'Employe not found'], 404);
        }

        // Supprimer l'employé
        $employe->delete();

        return response()->json([
            'message' => 'Employe deleted successfully'
        ], 200);
    }
}
