<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResarvationController extends Controller
{
    public function checkAvailability(Request $request)
{
    // Valider les données de la requête
    $validated = $request->validate([
        'id_etablissement' => 'required|exists:etablissements,id',  // L'ID de l'établissement
        'nombre' => 'required|integer|min:1',  // Le nombre de places demandées
        'date_debut' => 'required|date|after_or_equal:today',  // Date de début
        'date_fin' => 'required|date|after_or_equal:date_debut',  // Date de fin
    ]);

    // Récupérer l'établissement
    $etablissement = Etablissement::find($validated['id_etablissement']);

    // Vérifier si l'établissement existe
    if (!$etablissement) {
        return response()->json(['message' => 'Etablissement not found.'], 404);
    }

    // Vérifier la capacité de l'établissement
    $capacite_totale = $etablissement->capacite;

    // Vérifier le nombre de places déjà réservées dans cet établissement pour la période donnée
    $reservations_existantes = Reservation::where('id_etablissement', $etablissement->id)
        ->where(function($query) use ($validated) {
            $query->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
                  ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']]);
        })
        ->sum('nombre'); // Total des places réservées dans la période donnée

    // Vérifier si la capacité de l'établissement est suffisante
    if ($reservations_existantes + $validated['nombre'] > $capacite_totale) {
        return response()->json(['message' => 'Not enough capacity for the selected dates.'], 400);
    }

    // Si la capacité est suffisante
    return response()->json(['message' => 'Available for the selected dates.'], 200);
}



public function reserve(Request $request)
{
    // Valider les données de la requête
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',  // L'ID de l'utilisateur
        'id_etablissement' => 'required|exists:etablissements,id',  // L'ID de l'établissement
        'nombre' => 'required|integer|min:1',  // Le nombre de places réservées
        'date_debut' => 'required|date|after_or_equal:today',  // Date de début de la réservation
        'date_fin' => 'required|date|after_or_equal:date_debut',  // Date de fin de la réservation
    ]);

    // Vérifier la disponibilité avant de créer la réservation
    $availabilityResponse = $this->checkAvailability($request);
    
    if ($availabilityResponse->getStatusCode() !== 200) {
        return $availabilityResponse;  // Si la disponibilité échoue, renvoyer la réponse d'erreur
    }

    // Créer la réservation si tout est validé
    $reservation = Reservation::create([
        'id_user' => $validated['user_id'],  // ID de l'utilisateur
        'id_etablissement' => $validated['id_etablissement'],  // ID de l'établissement
        'nombre' => $validated['nombre'],  // Nombre de places réservées
        'date_debut' => $validated['date_debut'],  // Date de début de la réservation
        'date_fin' => $validated['date_fin'],  // Date de fin de la réservation
    ]);

    // Retourner une réponse avec les informations de la réservation
    return response()->json([
        'message' => 'Reservation created successfully',
        'reservation' => $reservation
    ], 201);
}
}
