<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entidad extends Model
{
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
}
