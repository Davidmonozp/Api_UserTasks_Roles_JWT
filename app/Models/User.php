<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que son asignables de forma masiva.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben ser ocultados para la serialización.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deberían ser casteados.
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

    /**
     * Obtener el identificador del JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Obtener las reclamaciones personalizadas del JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            // Puedes agregar datos adicionales si lo necesitas, por ejemplo:
            'role' => $this->role,
        ];
    }

    /**
     * Relación de un usuario a muchas tareas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Método para verificar si el usuario tiene el rol 'admin'.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Método para verificar si el usuario tiene el rol 'guest'.
     *
     * @return bool
     */
    public function isGuest()
    {
        return $this->role === 'guest';
    }
}
