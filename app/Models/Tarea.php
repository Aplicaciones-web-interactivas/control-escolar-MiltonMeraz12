<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'grupo_id',
        'profesor_id',
        'titulo',
        'descripcion',
        'fecha_limite',
    ];

    protected $casts = [
        'fecha_limite' => 'datetime',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

    public function yaEntrego(int $alumnoId): bool
    {
        return $this->entregas()->where('alumno_id', $alumnoId)->exists();
    }

    public function vencida(): bool
    {
        return now()->isAfter($this->fecha_limite);
    }
}