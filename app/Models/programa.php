<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\EstadoRevisionEnum;
use App\Enums\EstadoAutoridadEnum;
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
protected $casts = [
    'estado_revision' => EstadoRevisionEnum::class,
    'estado_autoridad' => EstadoAutoridadEnum::class,
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
/* RELACION 1:N UN PROGRAMA TIENE MUCHAS METAS ESTRATEGICAS*/
 public function metasEstrategicas()
{
    return $this->belongsToMany(metaEstrategica::class, 'programa_meta_estrategica', 'idPrograma', 
    'idMetaEstrategica');
}
}