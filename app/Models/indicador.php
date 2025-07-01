<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indicador extends Model
{
    use HasFactory;
protected $table = 'indicador'; 
protected $primaryKey='idIndicador';
public $timestamps =false;
protected $fillable = [
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
}
