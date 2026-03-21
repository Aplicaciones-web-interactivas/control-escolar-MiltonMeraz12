<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class)->withTimestamps();
    }
 
    public function gruposComoProfesor()
    {
        return $this->hasMany(Grupo::class, 'profesor_id');
    }
 
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function esProfesor(): bool
    {
        return $this->rol === 'profesor';
    }
 
    public function esAlumno(): bool
    {
        return $this->rol === 'alumno';
    }
 
    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }
}
