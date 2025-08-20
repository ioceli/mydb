<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TareaProyecto extends Model
{
    use HasFactory;
    protected $table = 'tarea_proyecto';
    protected $primaryKey = 'idTarea';
    protected $fillable = [
        'idActividad',
        'nombre',
        'monto',
    ];

    public function actividadesProyecto()
    {
        return $this->belongsTo(ActividadProyecto::class, 'idActividad', 'idActividad');
    }
}