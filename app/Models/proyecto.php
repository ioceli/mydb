<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class proyecto extends Model
{
   use HasFactory;
protected $table = 'proyecto'; 
protected $primaryKey='idProyecto';
public $timestamps =false;
protected $fillable = [
    'nombre',
    'estado',
];
}
