<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class objetivoDesarrolloSostenible extends Model
{
    use HasFactory;
protected $table = 'objetivo_desarrollo_sostenible'; 
protected $primaryKey='idObjetivoDesarrolloSostenible';
public $timestamps =false;
protected $fillable = [
    'numero',
    'nombre',
    'descripcion',
];
}
