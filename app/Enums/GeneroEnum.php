<?php

namespace App\Enums;

enum GeneroEnum: string
{
    case masculino = 'Masculino';
    case femenino = 'Femenino';
    case otro = 'Otro';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}