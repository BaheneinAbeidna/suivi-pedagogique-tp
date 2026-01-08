<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use Inertia\Inertia;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the students.
     */


    public function index()
    {
        $etudiants = Etudiant::all();

        return Inertia::render('Etudiants', [
            'etudiants' => $etudiants
        ]);
    }



    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        // Optional: return a Blade view for creating a student
    }

    /**
     * Store a newly created student in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:etudiants',
            'nom' => 'required',
            'prenom' => 'required',
            'filiere' => 'required',
            'niveau' => 'required|string',
        ]);

        Etudiant::create($request->all());

        return redirect()->route('etudiants.index');
    }

    /**
     * Display the specified student.
     */
    public function show(string $id)
    {
        // Optional: show a single student
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(string $id)
    {
        // Optional: return a Blade view to edit a student
    }

    /**
     * Update the specified student in the database.
     */
    public function update(Request $request, string $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $request->validate([
            'matricule' => 'required|unique:etudiants,matricule,' . $etudiant->id,
            'nom' => 'required',
            'prenom' => 'required',
            'filiere' => 'required',
            'niveau' => 'required|string',
        ]);

        $etudiant->update($request->all());

        return to_route('etudiants.index', [], 303);
    }

    /**
     * Remove the specified student from the database.
     */
    public function destroy(string $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        return to_route('etudiants.index', [], 303);
    }
}
