<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class metaPlanNacional extends Model
{
    use HasFactory;
protected $table = 'meta_plan_nacional'; 
protected $primaryKey='idMetaPlanNacional';
public $timestamps =false;
protected $fillable = [
    'idMetaEstrategica',
    'nombre',
    'descripcion',
    'porcentajeAlineacion',
];
/* RELACION N:1 UNA META DEL PLAN NACIONAL PERTENECE A UNA META ESTRATEGICA */
     public function metasEstrategicas(): BelongsToMany
    {
        return $this->belongsToMany(
            MetaEstrategica::class,
            'meta_pnd_meta_estrategica',
            'idMetaPlanNacional',
            'idMetaEstrategica'
        );
    }

}
