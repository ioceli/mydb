<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class metaEstrategica extends Model
{
    use HasFactory;
protected $table = 'meta_estrategica'; 
protected $primaryKey='idMetaEstrategica';
public $timestamps =false;
protected $fillable = [
    'idPlan',
    'nombre',
    'descripcion',
    'fechaInicio',
    'fechaFin',
    'formulaIndicador',
    'metaEsperada',
    'progresoActual',
    'tipoIndicador',
    'unidadMedida',
];
/* RELACION N:1 UNA META ESTRATEGICA PERTENECE A UN PLAN */
public function planes()
{
    return $this->belongsToMany(Plan::class, 'plan_meta_estrategica', 'idMetaEstrategica', 'idPlan');
}
/* RELACION N:1 UNA META ESTRATEGICA PERTENECE A UNA ENTIDAD */
 public function entidad(): BelongsTo
{
    return $this->belongsTo(entidad::class, 'idEntidad', 'idEntidad');
}
/* RELACION 1:N UNA META ESTRATEGICA TIENE MUCHAS METAS DEL PLAN NACIONAL*/
 public function metasPlanNacional()
{
    return $this->belongsToMany(metaPlanNacional::class, 'meta_pnd_meta_estrategica', 'idMetaEstrategica', 
    'idMetaPlanNacional');
}
/* RELACION 1:N UNA META ESTRATEGICA PUEDE TENER MUCHOS INDICADORES */
public function indicadores(): BelongsToMany
{
    return $this->belongsToMany(Indicador::class, 'indicador_meta_estrategica', 'idMetaEstrategica', 'idIndicador');
}
/* RELACION N:1 UNA META ESTRATEGICA PERTENECE A UN PLAN */
public function plan(): BelongsTo
{
    return $this->belongsTo(Plan::class, 'idPlan', 'idPlan');
}
}