<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class proyecto extends Model
{
   use HasFactory;
protected $table = 'proyecto'; 
protected $primaryKey='idProyecto';
public $timestamps =false;
protected $fillable = [
    'idEntidad',
    'nombre',
    'estado',
];
/* RELACION 1:N UN PROYECTO PERTENECE A UNA ENTIDAD*/
public function entidad ():BelongsTo
{
    return $this->belongsTo(entidad::class,'idEntidad','idEntidad');
}
/* RELACION 1:N UN PROGRAMA TIENE MUCHOS OBJETIVOS ESTRATEGICOS*/
public function objetivosEstrategicos()
{
    return $this->belongsToMany(ObjetivoEstrategico::class, 'proyecto_objetivo_estrategico', 
    'idProyecto', 'idObjetivoEstrategico');
}
}
