<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class objetivoDesarrolloSostenible extends Model
{
    use HasFactory;
protected $table = 'objetivo_desarrollo_sostenible'; 
protected $primaryKey='idObjetivoDesarrolloSostenible';
public $timestamps =false;
protected $fillable = [
    'idObjetivoEstrategico',
    'numero',
    'nombre',
    'descripcion',
];

// Relación muchos a muchos con Objetivo Estratégico
    public function objetivosEstrategicos()
    {
        return $this->belongsToMany(
            objetivoEstrategico::class,
            'objetivo_estrategico_ods',
            'idObjetivoDesarrolloSostenible',
            'idObjetivoEstrategico'
        );
    }
}