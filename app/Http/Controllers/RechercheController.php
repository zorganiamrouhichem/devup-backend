<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechercheController extends Controller
{
    public function rechercher(Request $request)
    {
        // Valider les données reçues
        $validated = $request->validate([
            'type' => 'required|string|in:Hotel,Complexe,Auberge,Lieu_touristique',
            'lieu' => 'required|string',
        ]);

        $type = $validated['type'];
        $lieu = $validated['lieu'];
        $resultats = [];

        // Rechercher selon le type
        switch ($type) {
            case 'Hotel':
            case 'Complexe':
                $resultats = DB::table('etablissements')
                    ->where('type', $type)
                    ->where('lieu', 'LIKE', "%$lieu%")
                    ->get();
                break;

            case 'Auberge':
                $resultats = DB::table('auberge')
                    ->where('lieu', 'LIKE', "%$lieu%")
                    ->get();
                break;

            case 'Lieu_touristique':
                $resultats = DB::table('lieu_touristique')
                    ->where('lieu', 'LIKE', "%$lieu%")
                    ->get();
                break;
        }

        // Retourner les résultats
        return response()->json([
            'success' => true,
            'data' => $resultats,
        ]);
    }
}
