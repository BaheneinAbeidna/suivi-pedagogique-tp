<?php

namespace App\Http\Controllers;

use App\Models\Encadrement;
use App\Models\Etudiant;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EncadrementController extends Controller
{
    /**
     * Display a listing of encadrements.
     */
    public function index()
    {
        $encadrements = Encadrement::with(['etudiant', 'enseignant'])->get();
        $etudiants = Etudiant::whereDoesntHave('encadrement')->get();
        $enseignants = Enseignant::all();

        return Inertia::render('Encadrements', [
            'encadrements' => $encadrements,
            'etudiants' => $etudiants,
            'enseignants' => $enseignants,
        ]);
    }

    /**
     * Store a newly created encadrement.
     */
    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id|unique:encadrements,etudiant_id',
            'enseignant_id' => 'required|exists:enseignants,id',
        ]);

        Encadrement::create([
            'etudiant_id' => $request->etudiant_id,
            'enseignant_id' => $request->enseignant_id,
        ]);

        return redirect()->route('encadrements.index')->with('success', 'Encadrement créé avec succès');
    }

    /**
     * Remove the specified encadrement.
     */
    public function destroy($id)
    {
        $encadrement = Encadrement::findOrFail($id);
        $encadrement->delete();

        return redirect()->route('encadrements.index')->with('success', 'Encadrement supprimé avec succès');
    }
}
