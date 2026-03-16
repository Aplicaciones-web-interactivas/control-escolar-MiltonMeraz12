<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['materia_id', 'profesor_id', 'nombre_grupo', 'horario', 'modalidad', 'cupo', 'salon'];

    public function materia() {
        return $this->belongsTo(Materia::class);
    }

    public function profesor() {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function alumnos() {
        return $this->belongsToMany(User::class);
    }
}
