<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = [
        'materia_id', 
        'profesor_id', 
        'nombre_grupo', 
        'horario', 
        'modalidad', 
        'cupo', 
        'salon',
        'dias',
        'hora_inicio',
        'hora_fin',
    ];

    public function materia() {
        return $this->belongsTo(Materia::class);
    }

    public function profesor() {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function alumnos() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function lugaresDisponibles(): int
    {
        return max(0, $this->cupo - $this->alumnos()->count());
    }
 
    public function tieneCupo(): bool
    {
        return $this->lugaresDisponibles() > 0;
    }
    
    public function porcentajeOcupacion(): int
    {
        if (!$this->cupo) return 0;
        return (int) round(($this->alumnos()->count() / $this->cupo) * 100);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
