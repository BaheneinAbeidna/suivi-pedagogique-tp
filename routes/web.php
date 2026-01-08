<?php

use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Etudiants Routes
Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
Route::put('/etudiants/{id}', [EtudiantController::class, 'update'])->name('etudiants.update');
Route::delete('/etudiants/{id}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');

// Enseignants Routes
Route::get('/enseignants', [EnseignantController::class, 'index'])->name('enseignants.index');
Route::post('/enseignants', [EnseignantController::class, 'store'])->name('enseignants.store');
Route::put('/enseignants/{id}', [EnseignantController::class, 'update'])->name('enseignants.update');
Route::delete('/enseignants/{id}', [EnseignantController::class, 'destroy'])->name('enseignants.destroy');
