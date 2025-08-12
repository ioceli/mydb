<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Componente extends Model
{
    use HasFactory;
    protected $table = 'componente';
    protected $primaryKey = 'idComponente';
    
    protected $fillable = [
        'idPrograma',
        'nombre',
        'descripcion',
        'monto',
    ];

    public function programas()
    {
        return $this->belongsTo(Programa::class, 'idPrograma', 'idPrograma');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'idComponente', 'idComponente');
    }
}