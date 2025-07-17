<?php

namespace App\Enums;

enum EstadoEnum: string
{
    case activo = 'Activo';
    case inactivo = 'Inactivo';
        
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}