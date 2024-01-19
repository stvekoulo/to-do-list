<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/login', [Authcontroller::class, 'login']);

// Routes nécessitant l'authentification avec le middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Route pour obtenir les informations de l'utilisateur authentifié
  //User
  Route::get('/user', [AuthController::class, 'user']);
  Route::post('/logout', [AuthController::class, 'logout']);

    // Routes pour la gestion des tâches
  Route::get('/tasks', [TaskController::class, 'index']);
  Route::post('/tasks', [TaskController::class, 'store']);
  Route::get('/tasks/{task}', [TaskController::class, 'show']);
  Route::put('/tasks/{task}', [TaskController::class, 'update']);
  Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
  Route::put('/tasks/{task}/change-status', [TaskController::class, 'changeStatus']);
});

