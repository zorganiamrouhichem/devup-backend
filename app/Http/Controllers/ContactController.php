<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function mail (Request $request)
    {
        
        // Valider les données entrantes
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Préparer les données pour l'email
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ];

        // Envoyer l'email
        try {
            Mail::send('email.name', ['data' => $data], function ($mail) use ($data) {
                $mail->to($data['email']) // Destinataire (client)
                    ->subject('il y a une activité ajouté')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            return response()->json(['message' => 'Email sent successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email.', 'details' => $e->getMessage()], 500);
        }
    }

    public function mailr (Request $request)
    {
        // Valider les données entrantes
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Préparer les données pour l'email
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ];

        // Envoyer l'email
        try {
            Mail::send('email.namer', ['data' => $data], function ($mail) use ($data) {
                $mail->to($data['email']) // Destinataire (client)
                    ->subject('il y a une place pour la réserver')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            return response()->json(['message' => 'Email sent successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email.', 'details' => $e->getMessage()], 500);
        }
    }
    public function testMail(Request $request)
{
    // Valider l'entrée
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'name' => 'required|string|max:500',
    ]);

    // Retourner une erreur si la validation échoue
    if ($validator->fails()) {
        return response()->json([
            'error' => 'Invalid input',
            'details' => $validator->errors()
        ], 422);
    }

    try {
        // Envoi de l'email
        Mail::send('email.name', ['data' => $request], function ($mail) use ($request) {
            $mail->to($request['email']) // Destinataire (client)
                 ->subject('il y a une place pour la réserver')
                 ->subject('Test Email');
        });

        return response()->json(['message' => 'Email sent successfully!'], 200);
    } catch (\Exception $e) {
        // Gestion des erreurs
        return response()->json([
            'error' => 'Failed to send email',
            'details' => $e->getMessage()
        ], 500); 
    }
}

public function testMailr(Request $request)
{
    // Valider l'entrée
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'name' => 'required|string|max:500',
    ]);

    // Retourner une erreur si la validation échoue
    if ($validator->fails()) {
        return response()->json([
            'error' => 'Invalid input',
            'details' => $validator->errors()
        ], 422);
    }

    try {
        // Envoi de l'email
        Mail::send('email.namer', ['data' => $request], function ($mail) use ($request) {
            $mail->to($request['email']) // Destinataire (client)
                 ->subject('il y a une place pour la réserver')
                 ->subject('Test Email');
        });

        return response()->json(['message' => 'Email sent successfully!'], 200);
    } catch (\Exception $e) {
        // Gestion des erreurs
        return response()->json([
            'error' => 'Failed to send email',
            'details' => $e->getMessage()
        ], 500); 
    }
}
}

