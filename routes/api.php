<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AubergeController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\ResarvationController;
use App\Http\Controllers\ReviewController;
use App\Models\AbonnementUser;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api_user');
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api_user');
Route::post('register', [AuthController::class, 'register']);

Route::get('reviews/{id_etablissement}', [ReviewController::class, 'index']);
Route::get('reviews/{id}', [ReviewController::class, 'show']);
Route::post('reviews', [ReviewController::class, 'store']);

Route::middleware(['auth:api_user',\App\Http\Middleware\CheckRole::class . ':user'])->group(function () {
    Route::post('/reservations', [ResarvationController::class, 'store']);
    Route::post('/subscribe', [AbonnementController::class, 'subscribe']);

});

Route::middleware(['auth:api_admin',\App\Http\Middleware\CheckRole::class . ':admin'])->group( function () {
    Route::get('/auberge/{id_admin}', [AubergeController::class, 'getAubergeByAdmin']);
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

    Route::get('reviews/{id_etablissement}', [ReviewController::class, 'index']);
    Route::get('reviews/{id}', [ReviewController::class, 'show']);
    Route::post('reviews', [ReviewController::class, 'store']);
});