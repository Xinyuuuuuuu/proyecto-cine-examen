<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/movies', [MovieController::class, 'index']);

//Crear
Route::get('/movies/create', [MovieController::class, 'create']);
Route::post('/movies', [MovieController::class, 'store']);

//Editar
Route::get('/movies/{id}/edit', [MovieController::class, 'edit']);
Route::post('/movies/{id}/update', [MovieController::class, 'update']);