<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metaPlanNacional extends Model
{
    use HasFactory;
protected $table = 'meta_plan_nacional'; 
protected $primaryKey='idMetaPlanNacional';
public $timestamps =false;
protected $fillable = [
    'numero',
    'nombre',
    'porcentajeAlineacion',
];
}
