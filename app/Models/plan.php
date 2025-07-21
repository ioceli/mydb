<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\EstadoRevisionEnum;
use App\Enums\EstadoAutoridadEnum;
class plan extends Model
{
    use HasFactory;
protected $table = 'plan'; 
protected $primaryKey='idPlan';
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
/* RELACION 1:N UN PLAN PERTENECE A UNA ENTIDAD*/
public function entidad ():BelongsTo
{
    return $this->belongsTo(entidad::class,'idEntidad','idEntidad');
}
/* RELACION 1:N UN PLAN TIENE MUCHOS OBJETIVOS ESTRATEGICOS*/
public function objetivosEstrategicos()
{
    return $this->belongsToMany(ObjetivoEstrategico::class, 'plan_objetivo_estrategico', 
    'idPlan', 'idObjetivoEstrategico');
}
/* RELACION 1:N UN PLAN TIENE MUCHAS METAS ESTRATEGICAS*/
 public function metasEstrategicas()
{
    return $this->belongsToMany(metaEstrategica::class, 'plan_meta_estrategica', 'idPlan', 
    'idMetaEstrategica');
}
}
