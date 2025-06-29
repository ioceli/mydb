<?php

namespace App\Enums;

enum EstadoEnum: string
{
    case activo = 'ACTIVO';
    case inactivo = 'INACTIVO';
        
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}