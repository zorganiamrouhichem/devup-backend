<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AubergeController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtablissementController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api_user');
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api_user');
Route::post('register', [AuthController::class, 'register']);



Route::middleware(['auth:api_user',\App\Http\Middleware\CheckRole::class . ':user'])->get('/user/dashboard', function () {
    return response()->json(['message' => 'Welcome to the User Dashboard']);
});

Route::middleware(['auth:api_admin',\App\Http\Middleware\CheckRole::class . ':admin'])->get('/admin/dashboard', function () {
    return response()->json(['message' => 'Welcome to the Admin Dashboard']);
});
Route::middleware(['auth:api_superadmin', \App\Http\Middleware\CheckRole::class . ':superadmin'])->group(function () {
     
    // Lister toutes les auberges
    Route::get('/auberge', [AubergeController::class, 'index']);
    Route::post('/auberge', [AubergeController::class, 'create']);
    Route::get('/auberge/{id}', [AubergeController::class, 'show']);
    Route::put('/auberge/{id}', [AubergeController::class, 'update']);
    Route::delete('/auberge/{id}', [AubergeController::class, 'destroy']);


    Route::get('etablissements', [EtablissementController::class, 'index']);
    Route::get('etablissements/{id}', [EtablissementController::class, 'show']);
    Route::post('etablissements', [EtablissementController::class, 'create']);
    Route::put('etablissements/{id}', [EtablissementController::class, 'update']);
    Route::delete('etablissements/{id}', [EtablissementController::class, 'destroy']);

    Route::get('activities', [ActivityController::class, 'index']);
});