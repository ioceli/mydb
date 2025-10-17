<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Helpers\BitacoraHelper;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Proyecto;
use App\Models\Entidad;
use App\Enums\EstadoRevisionEnum;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentoEstadoMail;
class RevisionController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inicializar variables de datos como colecciones paginadas
        $planes = collect();
        $programas = collect();
        $proyectos = collect();
        // Parámetros de la solicitud
        $tipoRevision = $request->input('tipo_revision'); // E.g., 'proyectos'
        $filtroSubsector = $request->input('subsector');
        $filtroEstado = $request->input('estado_revision');
        // Establecer el número de elementos por página, por defecto 10
        $perPage = $request->input('per_page', 10);
                // Datos para filtros dropdown (se cargan siempre)
        $subsectores = Entidad::select('subSector')->distinct()->pluck('subSector');
        // Usar los valores string para el dropdown
        $estadosRevision = array_map(fn($case) => $case instanceof \BackedEnum ? $case->value : $case, ['pendiente', 'Aprobado', 'Devuelto']);
        if ($tipoRevision) {
            $modelos = [
                'planes' => \App\Models\Plan::class,
                'programas' => \App\Models\Programa::class,
                'proyectos' => \App\Models\Proyecto::class,
            ];
            if (array_key_exists($tipoRevision, $modelos)) {
                $ModeloClase = $modelos[$tipoRevision];
                // Consulta base con relaciones necesarias
                $query = $ModeloClase::with('objetivosEstrategicos', 'metasEstrategicas', 'entidad');
                // Aplicar Filtro por Subsector de la Entidad
                if ($filtroSubsector) {
                    $query->whereHas('entidad', function ($q) use ($filtroSubsector) {
                        $q->where('subSector', $filtroSubsector);
                    });
                }
                // Aplicar Filtro por Estado de Revisión
                if ($filtroEstado) {
                    $query->where('estado_revision', $filtroEstado);
                }
                // Aplicar paginación usando $perPage y mantener filtros en la URL
                $results = $query->paginate($perPage)->withQueryString();
                // Asignar al array correspondiente
                if ($tipoRevision === 'planes') {
                    $planes = $results;
                } elseif ($tipoRevision === 'programas') {
                    $programas = $results;
                } elseif ($tipoRevision === 'proyectos') {
                    $proyectos = $results;
                }
                // Registro en Bitácora
                $filtrosActivos = array_filter(['Subsector' => $filtroSubsector, 'Estado' => $filtroEstado]);
                $filtrosDetalle = empty($filtrosActivos) ? 'sin filtros aplicados' : 'filtros: ' . json_encode($filtrosActivos);
                BitacoraHelper::registrar(
                    'Revisión', 
                    'Consultó listado de ' . ucfirst($tipoRevision), 
                    'Consulta de ' . $tipoRevision . ' realizada con ' . $filtrosDetalle . '.'
                );
            }
        }
        // Retornar la vista con todas las variables necesarias
        return view('revision.index', compact('planes', 'programas', 'proyectos', 'subsectores', 'estadosRevision','tipoRevision', 'perPage'         ));
    } 
    public function cambiarEstado(Request $request, $tipo, $id)
    {
        // 1. VALIDACIÓN AJUSTADA: Observaciones requeridas si el estado es 'Devuelto'
        $request->validate([
            'estado_revision' => 'required|in:pendiente,Aprobado,Devuelto',
            'tipo_revision' => 'required|in:planes,programas,proyectos', 
            'subsector' => 'nullable|string',
            'estado_revision_filtro' => 'nullable|string',
            'page' => 'nullable|integer', 
            'per_page' => 'nullable|integer',
            // NUEVA REGLA: Observaciones requeridas si el estado es Devuelto
            'observaciones_revision' => 'nullable|required_if:estado_revision,Devuelto|string|max:1000',
        ]);
        
        $modelos = [
            'planes' => \App\Models\Plan::class,
            'programas' => \App\Models\Programa::class,
            'proyectos' => \App\Models\Proyecto::class,
        ];
        
        if (!array_key_exists($tipo, $modelos)) {
            abort(404, 'Tipo inválido');
        }

        $modelo = $modelos[$tipo];
        $instancia = $modelo::findOrFail($id);

        $estadoNuevo = $request->estado_revision;
        $observaciones = null;
        
        // 2. ACTUALIZACIÓN DEL ESTADO Y OBSERVACIONES
        $instancia->estado_revision = $estadoNuevo;
        
        if ($estadoNuevo === 'Devuelto') {
            // Asumiendo que la columna se llama observaciones_revision
            $instancia->observaciones_revision = $request->observaciones_revision;
            $observaciones = $request->observaciones_revision;
        }

        $instancia->save();
        
        // 3. LÓGICA DE NOTIFICACIÓN A LA ENTIDAD
        $idEntidad = $instancia->idEntidad; // Obtener la Entidad del documento (asumiendo esta columna)
        $rol = 'Revisor Institucional';

        if ($idEntidad) {
            $usuariosEntidad = User::where('idEntidad', $idEntidad)->get();

            if ($usuariosEntidad->isNotEmpty()) {
                try {
                    // Enviar el Mailable a cada usuario de la Entidad
                    foreach ($usuariosEntidad as $user) {
                        Mail::to($user->email)->send(new DocumentoEstadoMail($instancia, $rol, $estadoNuevo, $observaciones));
                    }
                } catch (\Exception $e) {
                    \Log::error("Error de Mailable de Revisor (Entidad: {$idEntidad}): " . $e->getMessage());
                }
            }
        }
        
        // 4. Registro en Bitácora y Redirección
        BitacoraHelper::registrar(
            'Revisión', 
            'Cambio de Estado', 
            'Se actualizó el estado de ' . ucfirst($tipo) . ' con ID ' . $id . ' a: ' . $estadoNuevo
        );
        
        // Redirigir de vuelta al index manteniendo todos los filtros de la URL (incluida la paginación y per_page)
        return redirect()->route('revision.index', $request->only(['tipo_revision', 'subsector', 'estado_revision_filtro', 'page', 'per_page']))
                         ->with('success', ucfirst($tipo) . ' actualizado y notificado a los usuarios de la entidad.');
    }
      public function getDetalle($tipo, $id)
    {
        $modelos = [
            'planes' => \App\Models\Plan::class,
            'programas' => \App\Models\Programa::class,
            'proyectos' => \App\Models\Proyecto::class,
        ];
        if (!array_key_exists($tipo, $modelos)) {
            return response()->json(['error' => 'Tipo de documento inválido'], 404);
        }
        $modelo = $modelos[$tipo];
        $item = $modelo::with([
                'entidad', 
                'objetivosEstrategicos', 
                'metasEstrategicas',
            ])
            ->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $item,
            'tipo' => $tipo,
        ]);
    }
    public function downloadPdf($tipo, $id)
    {
        $modelos = [
            'planes' => \App\Models\Plan::class,
            'programas' => \App\Models\Programa::class,
            'proyectos' => \App\Models\Proyecto::class,
        ];
        if (!array_key_exists($tipo, $modelos)) {
            abort(404, 'Tipo de documento inválido');
        }
        $modelo = $modelos[$tipo];
        // Usar la misma lógica de carga que en getDetalle
        $item = $modelo::with([
                'entidad', 
                'objetivosEstrategicos', 
                'metasEstrategicas',
            ])->findOrFail($id);
        // La vista 'pdf.detalle' debe ser creada por ti para el formato del PDF
        $pdf = PDF::loadView('revision.detalle', compact('item', 'tipo'));
        $nombreDocumento = $item->nombre ? \Illuminate\Support\Str::slug($item->nombre) : $tipo . '-' . $id;
        BitacoraHelper::registrar(
             'Revisión', 
             'Descarga PDF', 
             'Descargó PDF de ' . ucfirst($tipo) . ' con ID ' . $id
        );
        return $pdf->download($nombreDocumento . '.pdf');
    }
}