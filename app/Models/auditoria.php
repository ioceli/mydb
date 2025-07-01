<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auditoria extends Model
{
    use HasFactory;
protected $table = 'auditoria'; 
protected $primaryKey='idAuditoria';
public $timestamps =false;
protected $fillable = [
    'nombre',
];
}
