<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class plan extends Model
{
    use HasFactory;
protected $table = 'plan'; 
protected $primaryKey='idPlan';
public $timestamps =false;
protected $fillable = [
    'idEntidad',
    'nombre',
    'estado',
];
/* RELACION 1:N UN PLAN PERTENECE A UNA ENTIDAD*/
public function entidad ():BelongsTo
{
    return $this->belongsTo(entidad::class,'idEntidad','idEntidad');
}
}
