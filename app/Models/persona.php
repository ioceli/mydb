<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class persona extends Model
{
use HasFactory;
protected $table = 'persona'; 
protected $primaryKey='idPersona';
public $timestamps =false;

protected $fillable = [
    'idEntidad',
    'cedula',
    'name',
    'apellidos',
    'rol',
    'estado',
    'correo',
    'genero',
    'telefono',
    'password',
];
/* RELACION 1:N UNA PERTENECE PERTENECE A UNA ENTIDAD*/
public function entidad ():BelongsTo
{
    return $this->belongsTo(entidad::class,'idEntidad','idEntidad');
}
}