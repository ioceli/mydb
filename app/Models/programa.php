<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class programa extends Model
{
   use HasFactory;
protected $table = 'programa'; 
protected $primaryKey='idPrograma';
public $timestamps =false;
protected $fillable = [
    'idEntidad',
    'nombre',
    'estado',
];
/* RELACION 1:N UN PROGRAMA PERTENECE A UNA ENTIDAD*/
public function entidad ():BelongsTo
{
    return $this->belongsTo(entidad::class,'idEntidad','idEntidad');
}
/* RELACION 1:N UN PROGRAMA TIENE MUCHOS OBJETIVOS ESTRATEGICOS*/
public function objetivosEstrategicos()
{
    return $this->belongsToMany(ObjetivoEstrategico::class, 'programa_objetivo_estrategico', 
    'idPrograma', 'idObjetivoEstrategico');
}
/* RELACION 1:N UN PROGRAMA TIENE MUCHAS METAS DEL PLAN NACIONAL*/
 public function metasPlanNacional()
{
    return $this->belongsToMany(metaPlanNacional::class, 'programa_meta_plan_nacional', 'idPrograma', 
    'idMetaPlanNacional');
}
}