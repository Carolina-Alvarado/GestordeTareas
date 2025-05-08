<?php

use Illuminate\Http\Request; // ✅ Agrega esta línea
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasklist', [TaskListController::class, 'index']);
    Route::post('/tasklist', [TaskListController::class, 'store']);
    Route::get('/tasklist/{id}', [TaskListController::class, 'show']);
    Route::patch('/tasklist/{id}/estado', [TaskListController::class, 'actualizarEstado']);
    Route::delete('/tasklist/{id}', [TaskListController::class, 'destroy']);
    Route::post('/tasklist/{id}/comentarios', [TaskListController::class, 'agregarComentario']);
});