<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class objetivoPlanNacional extends Model
{
    use HasFactory;
protected $table = 'objetivo_plan_nacional'; 
protected $primaryKey='idObjetivoPlanNacional';
public $timestamps =false;
protected $fillable = [
    'idObjetivoEstrategico',
    'codigo',
    'nombre',
    'descripcion',
    'ejePnd',
];
 // Relación muchos a muchos con Objetivo Estratégico
    public function objetivosEstrategicos()
    {
        return $this->belongsToMany(
            objetivoEstrategico::class,
            'objetivo_estrategico_opnd',
            'idObjetivoPlanNacional',
            'idObjetivoEstrategico'
        );
    }
}