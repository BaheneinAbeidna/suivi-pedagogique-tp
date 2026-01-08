<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the enseignants.
     */
    public function index()
    {
        $enseignants = Enseignant::with('etudiants')->get();

        return Inertia::render('Enseignants', [
            'enseignants' => $enseignants
        ]);
    }

    /**
     * Store a newly created enseignant in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:enseignants',
            'nom' => 'required',
            'prenom' => 'required',
            'specialite' => 'nullable',
        ]);

        Enseignant::create($request->all());

        return redirect()->back()->with('success', 'Enseignant ajouté avec succès.');
    }

    /**
     * Update the specified enseignant in the database.
     */
    public function update(Request $request, string $id)
    {
        $enseignant = Enseignant::findOrFail($id);

        $request->validate([
            'matricule' => 'required|unique:enseignants,matricule,' . $enseignant->id,
            'nom' => 'required',
            'prenom' => 'required',
            'specialite' => 'nullable',
        ]);

        $enseignant->update($request->all());

        return redirect()->back(303)->with('success', 'Enseignant mis à jour.');
    }

    /**
     * Remove the specified enseignant from the database.
     */

    public function destroy(string $id)
    {
        $enseignant = Enseignant::findOrFail($id);

        if ($enseignant->etudiants()->count() > 0) {
            return redirect()->back(303)->with('error', 'Impossible de supprimer cet enseignant car il a des étudiants assignés.');
        }

        $enseignant->delete();

        return redirect()->back(303)->with('success', 'Enseignant supprimé.');
    }
}
