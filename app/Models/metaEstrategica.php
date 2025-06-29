<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metaEstrategica extends Model
{
    use HasFactory;
protected $table = 'meta_estrategica'; 
protected $primaryKey='idMetaEstrategica';
public $timestamps =false;
protected $fillable = [
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
}
