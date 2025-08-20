<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActividadProyecto extends Model
{
    use HasFactory;
    protected $table = 'actividad_proyecto';
    protected $primaryKey = 'idActividad';
    protected $fillable = [
        'idComponente',
        'nombre',
        'monto',
    ];

    public function componentesProyecto()
    {
        return $this->belongsTo(ComponenteProyecto::class, 'idComponente', 'idComponente');
    }

    public function tareasProyecto()
    {
        return $this->hasMany(TareaProyecto::class, 'idActividad', 'idActividad');
    }
}