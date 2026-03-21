<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'user_id',
        'grupo_id',
        'parcial_1',
        'parcial_2',
        'parcial_3',
        'final',
    ];
 
    protected $casts = [
        'parcial_1' => 'float',
        'parcial_2' => 'float',
        'parcial_3' => 'float',
        'final'     => 'float',
    ];
  
    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
 
    public function recalcularFinal(): void
    {
        $parciales = collect([$this->parcial_1, $this->parcial_2, $this->parcial_3])
            ->filter(fn($v) => !is_null($v));
 
        $this->final = $parciales->isNotEmpty()
            ? round($parciales->avg(), 1)
            : null;
 
        $this->save();
    }
 
    public function estado(): string
    {
        if (is_null($this->final)) return 'pendiente';
        if ($this->final >= 6)   return 'aprobado';
        return 'reprobado';
    }
}
