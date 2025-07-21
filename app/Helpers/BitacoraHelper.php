<?php
namespace App\Helpers;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class BitacoraHelper
{
    public static function registrar($modulo, $accion)
    {
        Bitacora::create([
            'fecha'   => now(),
            'modulo'  => $modulo,
            'usuario' => Auth::check() ? Auth::user()->name : 'Invitado',
            'accion'  => $accion
        ]);
    }
}