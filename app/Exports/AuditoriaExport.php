<?php

namespace App\Exports;

use App\Models\Bitacora;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuditoriaExport implements FromCollection, WithHeadings
{
    protected $perPage;

    public function __construct($perPage)
    {
        $this->perPage = $perPage;
    }

    public function collection()
    {
        return Bitacora::select('fecha', 'usuario', 'modulo', 'accion')
            ->take($this->perPage) // limitar igual que la vista
            ->get();
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Usuario',
            'Módulo',
            'Acción'
        ];
    }
}