<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/connexion', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks/stats', [TaskController::class, 'getStats']);
Route::put('/tasks/{task}/change-status', [TaskController::class, 'changeStatus']);
Route::get('/tasks/{task}', [TaskController::class, 'show']);
Route::put('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
Route::get('/tasks', [TaskController::class, 'index']);

