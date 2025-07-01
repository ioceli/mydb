<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class entidad extends Model
{
use HasFactory;
protected $table = 'entidad'; 
protected $primaryKey='idEntidad';
public $timestamps =false;

protected $fillable = [
    'codigo',
    'subSector',
    'nivelGobierno',
    'estado',
    'fechaCreacion',
    'fechaActualizacion',
];
/* RELACION 1:N UNA ENTIDAD TIENE MUCHOS PROGRAMAS*/
public function programa ():HasMany
{
    return $this->hasMany(programa::class,'idEntidad','idEntidad');
}
}