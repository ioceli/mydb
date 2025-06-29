<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class objetivoPlanNacional extends Model
{
    use HasFactory;
protected $table = 'objetivo_plan_nacional'; 
protected $primaryKey='idObjetivoPlanNacional';
public $timestamps =false;
protected $fillable = [
    'codigo',
    'nombre',
    'descripcion',
    'ejePnd',
];
}
