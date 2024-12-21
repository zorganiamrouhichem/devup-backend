<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AubergeController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\ResarvationController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ReviewController;
use App\Models\AbonnementUser;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api_user');
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api_user');
Route::post('register', [AuthController::class, 'register']);
Route::get('/user/{id}/name', [AuthController::class, 'getUserNameById']);

// test gmail send activité
// Route::post('send/email', [ContactController::class, 'mail'])->name('email');

// Route::post('send/email',[ContactController::class, 'mail'])->name('email');
Route::post('send/email',[ContactController::class, 'testMail'])->name('emailt');
Route::post('send/emailr',[ContactController::class, 'testMailr'])->name('emailtr');
// test gmail send reserve 
// Route::post('send/emailr',[ContactController::class, 'mailr'])->name('emailr');

Route::post('/check-availability', [ResarvationController::class, 'checkAvailability']);

// Route pour créer la réservation
Route::get('reviews/{id_etablissement}', [ReviewController::class, 'index']);
Route::get('reviews/{id}', [ReviewController::class, 'show']);
Route::post('reviews', [ReviewController::class, 'store']);
Route::post('/recherche', [RechercheController::class, 'rechercher']);


Route::middleware(['auth:api_user',\App\Http\Middleware\CheckRole::class . ':user'])->group(function () {
    Route::post('/reservations', [ResarvationController::class, 'store']);
    Route::post('/subscribe', [AbonnementController::class, 'subscribe']);
    Route::post('/reserve', [ResarvationController::class, 'reserve']);
    Route::get('reviews/{id}', [ReviewController::class, 'show']);
    Route::post('reviews', [ReviewController::class, 'store']);
    Route::post('/reserve', [ResarvationController::class, 'reserve']);




});

Route::middleware(['auth:api_admin',\App\Http\Middleware\CheckRole::class . ':admin'])->group( function () {
    Route::get('/auberge/{id_admin}', [AubergeController::class, 'getAubergeByAdmin']);

    Route::get('/resident', [ResidentController::class, 'index']);
    Route::post('/resident', [ResidentController::class, 'create']);
    Route::get('/resident/{id}', [ResidentController::class, 'show']);
    Route::put('/resident/{id}', [ResidentController::class, 'update']);
    Route::delete('/resident/{id}', [ResidentController::class, 'destroy']);

    // lister toutes les employés
    Route::get('employe', [EmployeController::class, 'index']);
    Route::post('/employe', [EmployeController::class, 'create']);
    Route::get('/employe/{id}', [EmployeController::class, 'show']);
    Route::put('/employe/{id}', [EmployeController::class, 'update']);
    Route::delete('/employe/{id}', [EmployeController::class, 'destroy']);

    // lister gens dans blacklist
    Route::get('/blacklist', [BlackListController::class, 'index']);
    Route::post('/blacklist', [BlacklistController::class, 'create']);
    Route::get('/blacklist/{id}', [BlacklistController::class, 'show']);
    Route::put('/blacklist/{id}', [BlacklistController::class, 'update']);
    Route::delete('/blacklist/{id}', [BlacklistController::class, 'destroy']);
});
Route::get('etablissements', [EtablissementController::class, 'index']);
Route::get('/auberge', [AubergeController::class, 'index']);
Route::get('activities', [ActivityController::class, 'index']);
Route::get('reviews/{id_etablissement}', [ReviewController::class, 'index']);
Route::get('etablissements/{id}', [EtablissementController::class, 'show']);




Route::middleware(['auth:api_superadmin', \App\Http\Middleware\CheckRole::class . ':superadmin'])->group(function () {
     
    // Lister toutes les auberges
    Route::post('/auberge', [AubergeController::class, 'create']);
    Route::get('/auberge/{id}', [AubergeController::class, 'show']);
    Route::put('/auberge/{id}', [AubergeController::class, 'update']);
    Route::delete('/auberge/{id}', [AubergeController::class, 'destroy']);


    Route::post('etablissements', [EtablissementController::class, 'create']);
    Route::put('etablissements/{id}', [EtablissementController::class, 'update']);
    Route::delete('etablissements/{id}', [EtablissementController::class, 'destroy']);


   
});