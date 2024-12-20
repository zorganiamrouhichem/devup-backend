<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auberge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AubergeController extends Controller
{
    /**
     * Créer un administrateur et une auberge en même temps.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed', // mot de passe confirmé
            'auberge_nom' => 'required|string|max:255',
            'auberge_capacite' => 'required|integer',
            'auberge_etat' => 'required|string|max:255',
            'auberge_service' => 'required|string|max:255',
            'lieu' => 'required|string|max:255',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Créer un utilisateur admin
            $admin = User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['admin_password']),
                'role' => 'admin', // Assigner le rôle 'admin' à cet utilisateur
            ]);

            // Créer l'auberge et associer l'admin à cette auberge
            $auberge = Auberge::create([
                'nom' => $validated['auberge_nom'],
                'capacite' => $validated['auberge_capacite'],
                'etat' => $validated['auberge_etat'],
                'service' => $validated['auberge_service'],
                'lieu' => $validated['lieu'],
                'id_admin' => $admin->id, // Assigner l'ID de l'admin
            ]);

            // Commit the transaction if everything went well
            DB::commit();

            // Retourner la réponse avec les informations de l'auberge et de l'admin
            return response()->json([
                'message' => 'Auberge and admin created successfully',
                'auberge' => $auberge,
                'admin' => $admin
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            DB::rollBack();

            // Return the error message
            return response()->json([
                'message' => 'Error occurred while creating auberge and admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        // Récupérer toutes les auberges
        $auberges = Auberge::all();
        
        return response()->json($auberges, 200); // Retourne les auberges en réponse JSON
    }

    /**
     * Affiche les détails d'une auberge spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Récupérer l'auberge par son ID
        $auberge = Auberge::find($id);

        if (!$auberge) {
            return response()->json(['message' => 'Auberge not found'], 404); // Si l'auberge n'existe pas
        }

        return response()->json($auberge, 200); // Retourner l'auberge trouvée
    }

    /**
     * Met à jour les informations d'une auberge spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation des données de l'auberge
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'required|integer',
            'etat' => 'required|string|max:255',
            'service_commune' => 'required|string|max:255',
        ]);

        // Récupérer l'auberge par son ID
        $auberge = Auberge::find($id);

        if (!$auberge) {
            return response()->json(['message' => 'Auberge not found'], 404); // Si l'auberge n'existe pas
        }

        // Mettre à jour les informations de l'auberge
        $auberge->update($validated);

        return response()->json([
            'message' => 'Auberge updated successfully',
            'auberge' => $auberge
        ], 200);
    }

    /**
     * Supprime une auberge spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Récupérer l'auberge par son ID
        $auberge = Auberge::find($id);

        if (!$auberge) {
            return response()->json(['message' => 'Auberge not found'], 404); // Si l'auberge n'existe pas
        }

        // Supprimer l'auberge
        $auberge->delete();

        return response()->json([
            'message' => 'Auberge deleted successfully'
        ], 200);
    }
    public function getAubergeByAdmin($id_admin)
    {
        // Recherche de l'auberge en fonction de l'id_admin
        $auberge = Auberge::where('id_admin', $id_admin)->first();

        // Vérifier si une auberge a été trouvée
        if (!$auberge) {
            return response()->json(['message' => 'Auberge not found for this admin'], 404);
        }

        // Retourner la réponse avec l'id de l'auberge
        return response()->json([
            'id_auberge' => $auberge->id
        ], 200);
    }
}
