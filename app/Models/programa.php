<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class programa extends Model
{
   use HasFactory;
protected $table = 'programa'; 
protected $primaryKey='idPrograma';
public $timestamps =false;
protected $fillable = [
    'nombre',
    'estado',
];
}
