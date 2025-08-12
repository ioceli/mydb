<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actividad extends Model
{
    use HasFactory;
    protected $table = 'actividad';
    protected $primaryKey = 'idActividad';
    protected $fillable = [
        'idComponente',
        'nombre',
        'monto',
    ];

    public function componentes()
    {
        return $this->belongsTo(Componente::class, 'idComponente', 'idComponente');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'idActividad', 'idActividad');
    }
}