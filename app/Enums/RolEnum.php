<?php

namespace App\Enums;

enum RolEnum: string
{
    case admin = 'Administrador del Sistema';
    case tecnico = 'Técnico de Planificación';
    case revisor = 'Revisor Institucional';
    case autoridad = 'Autoridad Validante';
    case externo = 'Usuario Externo';
    case auditor = 'Auditor';
    case desarrollador = 'Desarrollador';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}