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
/* RELACION 1:N UNA ENTIDAD TIENE MUCHAS PERSONAS*/
public function user ():HasMany
{
    return $this->hasMany(user::class,'idEntidad','idEntidad');
}
/* RELACION 1:N UNA ENTIDAD TIENE MUCHOS PLANES*/
public function plan ():HasMany
{
    return $this->hasMany(plan::class,'idEntidad','idEntidad');
}
/* RELACION 1:N UNA ENTIDAD TIENE MUCHOS PROYECTOS*/
public function proyecto ():HasMany
{
    return $this->hasMany(proyecto::class,'idEntidad','idEntidad');
}
}