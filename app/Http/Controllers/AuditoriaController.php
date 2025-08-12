<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AuditoriaExport;
use Maatwebsite\Excel\Facades\Excel;
class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $bitacoras = Bitacora::latest('fecha')->paginate($perPage);
    return view('auditoria.index', compact('bitacoras', 'perPage'));
}

public function exportPdf(Request $request)
{
    $perPage = $request->input('per_page', 100);
    $bitacoras = Bitacora::latest('fecha')->paginate($perPage);

    // Cargar la vista y pasar los datos
    $pdf = Pdf::loadView('auditoria.pdf', compact('bitacoras'));

    return $pdf->download('reporte_bitacora.pdf');
}

public function exportExcel(Request $request)
{
    $perPage = $request->input('per_page', 100);
    return Excel::download(new AuditoriaExport($perPage), 'reporte_bitacora.xlsx');
}
}