<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
/* RELACION 1:N UN PLAN PERTENECE PERTENECE A UN OBJETIVO ESTRATEGICO*/
 public function plan(): BelongsTo
{
    return $this->belongsTo(Plan::class, 'idPlan', 'idPlan');
} 

}