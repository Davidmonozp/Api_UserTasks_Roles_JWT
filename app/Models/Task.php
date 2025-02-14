<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables de forma masiva.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    /**
     * Relación de una tarea a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica si la tarea pertenece al usuario dado.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function isOwnedBy(User $user)
    {
        return $this->user_id === $user->id;
    }
}

