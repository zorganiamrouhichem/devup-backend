<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResarvationController extends Controller
{
     /**
     * Créer une nouvelle réservation pour un utilisateur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id', // Vérifier que l'utilisateur existe
            'id_etablissement' => 'required|exists:etablissements,id', // Vérifier que l'établissement existe
            'nombre' => 'required|integer|min:1', // Le nombre de personnes doit être un entier et supérieur à 0
            'date_debut' => 'required|date|after_or_equal:today', // La date de début doit être une date valide et après ou égale à aujourd'hui
            'date_fin' => 'required|date|after:date_debut', // La date de fin doit être une date valide et après la date de début
        ]);

        // Vérifier la disponibilité de l'établissement pendant la période demandée
        $etablissement = Etablissement::find($validated['id_etablissement']);

        // Vérifier si la capacité de l'établissement est suffisante pendant la période de réservation
        $reservations = Reservation::where('id_etablissement', $validated['id_etablissement'])
            ->where(function ($query) use ($validated) {
                // Vérifier si les dates de réservation se chevauchent avec une réservation existante
                $query->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
                    ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('date_debut', '<=', $validated['date_debut'])
                            ->where('date_fin', '>=', $validated['date_fin']);
                    });
            })
            ->sum('nombre'); // Calculer la somme des personnes réservées pour cet établissement sur cette période

        // Vérifier que la capacité totale n'est pas dépassée
        if ($etablissement->capacite < ($reservations + $validated['nombre'])) {
            return response()->json(['message' => 'Capacity exceeded for the selected dates'], 400);
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'id_user' => $validated['id_user'],
            'id_etablissement' => $validated['id_etablissement'],
            'nombre' => $validated['nombre'],
            'date_debut' => Carbon::parse($validated['date_debut']),
            'date_fin' => Carbon::parse($validated['date_fin']),
        ]);

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => $reservation,
        ], 201);
    }
}
