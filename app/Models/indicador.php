<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class indicador extends Model
{
    use HasFactory;
protected $table = 'indicador'; 
protected $primaryKey='idIndicador';
public $timestamps =false;
protected $fillable = [
    'idMetaEstrategica',
    'nombre',
    'descripcion',
    'fechaMedicion',
    'formula',
    'tipo',
    'unidadMedida',
    'valorActual',
    'valorBase',
    'valorMeta',
];
/* RELACION N:1 UN INDICADOR PERTENECE A UNA META ESTRATEGICA */
public function metasEstrategicas(): BelongsToMany
{
    return $this->belongsToMany(metaEstrategica::class, 'indicador_meta_estrategica', 'idIndicador', 'idMetaEstrategica');
}
}