<?php

namespace App\Enums;

enum EjePndEnum: string
{
    case social = 'EJE SOCIAL';
    case desarrollo = 'EJE DESARROLLO ECONOMICO';
    case infraestructura = 'EJE INFRAESTRUCTURA ENERCIA MEDIO AMBIENTE';    
    case institucional = 'EJE INSTITUCIONAL';
    case gestion = 'EJE GESTION RIESGOS';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}