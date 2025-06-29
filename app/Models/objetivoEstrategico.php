<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class objetivoEstrategico extends Model
{
    use HasFactory;
protected $table = 'objetivo_estrategico'; 
protected $primaryKey='idObjetivoEstrategico';
public $timestamps =false;
protected $fillable = [
    'descripcion',
    'fechaRegistro',
    'estado',
];
}
