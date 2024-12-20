<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api_user');
Route::post('register', [AuthController::class, 'register']);



Route::middleware(['auth:api_user',\App\Http\Middleware\CheckRole::class . ':user'])->get('/user/dashboard', function () {
    return response()->json(['message' => 'Welcome to the User Dashboard']);
});

Route::middleware(['auth:api_admin',\App\Http\Middleware\CheckRole::class . ':admin'])->get('/admin/dashboard', function () {
    return response()->json(['message' => 'Welcome to the Admin Dashboard']);
});
Route::middleware(['auth:api_superadmin', \App\Http\Middleware\CheckRole::class . ':superadmin'])->get('/superadmin/dashboard', function () {
    return response()->json(['message' => 'Welcome to the super admin Dashboard']);
});