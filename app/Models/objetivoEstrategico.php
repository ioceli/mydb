<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
// Relación con Plan
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'idPlan', 'idPlan');
    }

    // Relación N:M con ODS
    public function ods()
    {
        return $this->belongsToMany(
            objetivoDesarrolloSostenible::class,
            'objetivo_estrategico_ods',
            'idObjetivoEstrategico',
            'idObjetivoDesarrolloSostenible'
        );
    }

    // Relación N:M con OPND
    public function opnd()
    {
        return $this->belongsToMany(
            objetivoPlanNacional::class,
            'objetivo_estrategico_opnd',
            'idObjetivoEstrategico',
            'idObjetivoPlanNacional'
        );
    }
}