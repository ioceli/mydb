<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 public function plan(): BelongsTo
{
    return $this->belongsTo(Plan::class, 'idPlan', 'idPlan');
}
/* RELACION 1:N UNA META ESTRATEGICA PUEDE TENER MUCHAS METAS DEL PLAN NACIONAL */
 public function metaPlanNacional(): HasMany
{
    return $this->hasMany(metaPlanNacional::class, 'idMetaEstrategica', 'idMetaEstrategica');
}
/* RELACION 1:N UNA META ESTRATEGICA PUEDE TENER MUCHOS INDICADORES */
 public function indicador(): HasMany
{
    return $this->hasMany(indicador::class, 'idMetaEstrategica', 'idMetaEstrategica');

}
}