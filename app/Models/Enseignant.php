<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'specialite',
    ];

    /**
     * Get the students supervised by this enseignant.
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'enseignant_id');
    }

    public function encadrements()
    {
        return $this->hasMany(Encadrement::class);
    }
}
