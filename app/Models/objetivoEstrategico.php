<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class objetivoEstrategico extends Model
{
    use HasFactory;
protected $table = 'objetivo_estrategico'; 
protected $primaryKey='idObjetivoEstrategico';
public $timestamps =false;
protected $fillable = [
    'idPlan',
    'descripcion',
    'fechaRegistro',
    'estado',
];
public function plan()
{
    return $this->hasMany(Plan::class, 'idObjetivoEstrategico');
}
}
