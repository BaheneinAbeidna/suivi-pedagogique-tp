<?php

use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\EncadrementController;
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

// Absences Routes
Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');
Route::post('/absences', [AbsenceController::class, 'store'])->name('absences.store');
Route::delete('/absences/{id}', [AbsenceController::class, 'destroy'])->name('absences.destroy');

// Encadrements Routes
Route::get('/encadrements', [EncadrementController::class, 'index'])->name('encadrements.index');
Route::post('/encadrements', [EncadrementController::class, 'store'])->name('encadrements.store');
Route::delete('/encadrements/{id}', [EncadrementController::class, 'destroy'])->name('encadrements.destroy');
