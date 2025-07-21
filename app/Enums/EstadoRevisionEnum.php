<?php

namespace App\Enums;

enum EstadoRevisionEnum: string
{
    case pendiente = 'pendiente';
    case aprobado = 'Aprobado';
    case devuelto = 'Devuelto';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public static function labels(): array
    {
        return [
            self::pendiente->value => 'pendiente',
            self::aprobado->value => 'Aprobado',
            self::devuelto->value => 'Devuelto',
        ];
    }
    
}