<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'filiere',
        'niveau',
        'enseignant_id',
    ];

    /**
     * The enseignant that supervises the student.
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function encadrement()
    {
        return $this->hasOne(Encadrement::class);
    }
}
