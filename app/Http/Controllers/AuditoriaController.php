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
    // Obtener filtros desde la solicitud
    $fechaDesde = $request->input('fecha_desde');
    $fechaHasta = $request->input('fecha_hasta');
    $usuario = $request->input('usuario');
    $modulo = $request->input('modulo');
    $accion = $request->input('accion');
    $perPage = $request->input('per_page', 10); // Valor por defecto: 10

    // Consulta base
    $query = Bitacora::query();

    if ($request->filled('fecha_desde')) {
        $query->whereDate('fecha', '>=', $request->fecha_desde);
    }
    if ($request->filled('fecha_hasta')) {
        $query->whereDate('fecha', '<=', $request->fecha_hasta);
    }
    if ($request->filled('usuario')) {
        $query->where('usuario', $request->usuario);
    }
    if ($request->filled('modulo')) {
        $query->where('modulo', $request->modulo);
    }
    if ($request->filled('accion')) {
        $query->where('accion', $request->accion);
    }
    // Obtener resultados paginados
    $bitacoras = $query->orderBy('fecha', 'desc')->paginate($perPage);
    // Mantener filtros en la paginación
    $bitacoras->appends($request->all());
    
    $usuarios = Bitacora::select('usuario')->distinct()->get();
    $modulos = Bitacora::select('modulo')->distinct()->get();
    $acciones = Bitacora::select('accion')->distinct()->get();

    return view('auditoria.index', compact('bitacoras', 'perPage', 'usuarios', 'modulos', 'acciones'));
}

public function exportPdf(Request $request)
{
    $perPage = $request->input('per_page', 10, 50, 100);
    $bitacoras = Bitacora::latest('fecha')->paginate($perPage);

    // Cargar la vista y pasar los datos
    $pdf = Pdf::loadView('auditoria.pdf', compact('bitacoras'));

    return $pdf->download('reporte_bitacora.pdf');
}

public function exportExcel(Request $request)
{
    $perPage = $request->input('per_page', 10, 50, 100);
    return Excel::download(new AuditoriaExport($perPage), 'reporte_bitacora.xlsx');
}
}