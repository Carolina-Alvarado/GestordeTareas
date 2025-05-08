<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TaskList extends Model
{
    protected $fillable = [
        'user_id', 'titulo', 'descripcion', 'prioridad', 'estado', 'fecha_vencimiento', 'comentarios'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


