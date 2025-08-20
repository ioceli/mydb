<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComponentePrograma extends Model
{
    use HasFactory;
    protected $table = 'componente_programa';
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
    

    public function actividadesPrograma()
    {
        return $this->hasMany(ActividadPrograma::class, 'idComponente', 'idComponente');
    }
}