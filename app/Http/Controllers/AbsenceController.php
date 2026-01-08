<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Absence;
use App\Models\Etudiant;
use Inertia\Inertia;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with('etudiant')->get();
        $etudiants = Etudiant::all();

        return Inertia::render('Absences', [
            'absences' => $absences,
            'etudiants' => $etudiants
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'date' => 'required|date',
            'motif' => 'nullable|string',
        ]);

        Absence::create($request->all());

        return redirect()->route('absences.index');
    }

    public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->route('absences.index');
    }
}
