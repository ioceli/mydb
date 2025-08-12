<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tarea';
    protected $primaryKey = 'idTarea';
    protected $fillable = [
        'idActividad',
        'nombre',
        'monto',
    ];

    public function actividades()
    {
        return $this->belongsTo(Actividad::class, 'idActividad', 'idActividad');
    }
}