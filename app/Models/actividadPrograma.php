<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActividadPrograma extends Model
{
    use HasFactory;
    protected $table = 'actividad_programa';
    protected $primaryKey = 'idActividad';
    protected $fillable = [
        'idComponente',
        'nombre',
        'monto',
    ];

    public function componentesPrograma()
    {
        return $this->belongsTo(ComponentePrograma::class, 'idComponente', 'idComponente');
    }

    public function tareasPrograma()
    {
        return $this->hasMany(TareaPrograma::class, 'idActividad', 'idActividad');
    }
}