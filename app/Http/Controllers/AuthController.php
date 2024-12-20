<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string|in:user,admin,superadmin', // Validate the role to be either 'user' or 'admin'
    ]);

    
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
    
    return response()->json([
        'message' => 'User successfully registered',
    ]);
}

    // Login function to authenticate and return a JWT token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            // Tenter de créer un token JWT avec les informations d'identification
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
            
            // Vous pouvez ici vérifier le rôle de l'utilisateur et générer un token en fonction de cela
            $user = JWTAuth::user();
           
            if ($user->role === 'admin') {
                // Si l'utilisateur est un admin, vous pouvez, par exemple, ajouter un "claim" spécial
                $token = JWTAuth::fromUser($user, ['role' => 'admin']);
            } if ($user->role === 'superadmin') {
                // Si l'utilisateur est un superadmin, vous pouvez, par exemple, ajouter un "claim" spécial
                $token = JWTAuth::fromUser($user, ['role' => 'superadmin']);
            } else {
                // Si l'utilisateur est un utilisateur normal, vous pouvez, par exemple, ajouter un "claim" spécial
                $token = JWTAuth::fromUser($user);
            }
            // nrecupiri role tee user ou generilou token special
    
            // Si tout va bien, retourner le token généré
            return response()->json([
                'token' => $token,
                'role' => $user->role
            ]);
    
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
}
    // Optional: Add a logout function to invalidate the JWT token
    public function logout(Request $request)
{
    try {
        // Récupérer le token à partir des en-têtes de la requête
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json(['error' => 'No token provided'], 400);
        }

        // Invalider le token pour le rendre inutilisable
        JWTAuth::invalidate($token);

        return response()->json(['message' => 'Successfully logged out']);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Could not log out, please try again'], 500);
    }
}
}
