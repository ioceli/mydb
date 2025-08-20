<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComponenteProyecto extends Model
{
    use HasFactory;
    protected $table = 'componente_proyecto';
    protected $primaryKey = 'idComponente';
    
    protected $fillable = [
        'idProyecto',
        'nombre',
        'descripcion',
        'monto',
    ];

    public function proyectos()
    {
        return $this->belongsTo(Proyecto::class, 'idProyecto', 'idProyecto');
    }
    

    public function actividadesProyecto()
    {
        return $this->hasMany(ActividadProyecto::class, 'idComponente', 'idComponente');
    }
}