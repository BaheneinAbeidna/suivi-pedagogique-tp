<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encadrement extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'enseignant_id',
    ];

    /**
     * Get the student associated with the encadrement.
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    /**
     * Get the teacher associated with the encadrement.
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
