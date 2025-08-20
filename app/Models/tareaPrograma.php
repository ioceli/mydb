<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TareaPrograma extends Model
{
    use HasFactory;
    protected $table = 'tarea_programa';
    protected $primaryKey = 'idTarea';
    protected $fillable = [
        'idActividad',
        'nombre',
        'monto',
    ];

    public function actividadesPrograma()
    {
        return $this->belongsTo(ActividadPrograma::class, 'idActividad', 'idActividad');
    }
}