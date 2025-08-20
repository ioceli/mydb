<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\EstadoRevisionEnum;
use App\Enums\EstadoAutoridadEnum;
class proyecto extends Model
{
   use HasFactory;
protected $table = 'proyecto'; 
protected $primaryKey='idProyecto';
public $timestamps =false;
protected $fillable = [
    'cup',
    'idEntidad',
    'tipo_dictamen',
    'nombre',
    'accion',
    'objeto',
    'plazo_ejecucion',
    'monto_total',
    'diagnostico',
    'problema',
    'longitud',
    'latitud',
];
public static function generarCUP(): string
{
        $ultimo = self::orderBy('idProyecto', 'asc')->get()->last();
    $numero = $ultimo ? ((int) filter_var($ultimo->cup, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
    return 'CUP' . str_pad($numero, 4, '0', STR_PAD_LEFT);
}

protected $casts = [
    'estado_revision' => EstadoRevisionEnum::class,
    'estado_autoridad' => EstadoAutoridadEnum::class,
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
/* RELACION 1:N UN PROYECTO TIENE MUCHAS METAS ESTRATEGICAS*/
public function metasEstrategicas()
{
    return $this->belongsToMany(metaEstrategica::class, 'proyecto_meta_estrategica', 'idProyecto', 
    'idMetaEstrategica');   
}
    public function componentesProyecto()
{
    return $this->hasMany(ComponenteProyecto::class, 'idProyecto', 'idProyecto');
}
}