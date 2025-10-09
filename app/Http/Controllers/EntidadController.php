<?php

namespace App\Http\Controllers;
use App\Helpers\BitacoraHelper;
use App\Models\entidad;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Validation\Rules\Unique;
use Ramsey\Uuid\Type\Integer;
use App\Enums\EstadoEnum;
use Illuminate\Validation\Rule;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    $estado = $request->input('estado');
    $nivelGobierno = $request->input('nivelGobierno');
    $fechaDesde = $request->input('fecha_desde');
    
    $perPage = $request->input('per_page', 10); // Valor por defecto: 10
    // Consulta base
    $query = Entidad::query();
    // Aplicar filtros condicionalmente
    if ($request->filled('estado')) {
        $query->where('estado', $estado);
    }
    if ($request->filled('nivelGobierno')) {
        // Asegúrate de que 'subSector' coincida con el nombre de la columna en tu BD
        $query->where('nivelGobierno', $nivelGobierno); 
    }
     // Filtro por rango de fecha de creación
    if ($request->filled('fecha_desde')) {
        $query->whereDate('fechaCreacion', '>=', $fechaDesde);
    }
    
     // Obtener resultados paginados
    $entidad = $query->orderBy('idEntidad', 'asc')->paginate($perPage);
    // Mantener todos los parámetros de la solicitud (filtros y per_page) en los enlaces de paginación
    $entidad->appends($request->all());
    // Obtener valores únicos para los filtros de dropdown (mejora la UX)
    $estados = Entidad::select('estado')->distinct()->pluck('estado');
    $nivelesGobierno = Entidad::select('nivelGobierno')->distinct()->pluck('nivelGobierno');
        // Pasar datos a la vista
    return view('entidad.index', compact('entidad', 'perPage', 'estados', 'nivelesGobierno'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('entidad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        BitacoraHelper::registrar('Entidad', 'Creó una nueva entidad');
        $request->validate([
            'codigo'=>'required|integer|unique:entidad,codigo',
            'subSector'=>'required|string',
            'nivelGobierno'=>'required|string',
             'estado'=>['required',Rule::in(EstadoEnum::values())],
            'fechaCreacion'=>'required|date',
            'fechaActualizacion'=>'required|date',
       ]);
       entidad::create($request->all());
    return redirect()->route('entidad.index')->with('success','Entidad Creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(entidad $entidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $entidad = entidad::findOrfail($id);
        return view('entidad.edit',compact('entidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        BitacoraHelper::registrar('Entidad', 'Actualizó la entidad con ID ' . $id);
        // Buscar la entidad por su ID
    $entidad = Entidad::findOrFail($id);
        //Validar Datos
            $request->validate([
            'codigo'=>['required','integer', Rule::unique('entidad','codigo')->ignore($entidad->idEntidad, 'idEntidad')],
            'subSector'=>'required|string',
            'nivelGobierno'=>'required|string',
             'estado'=>['required',Rule::in(EstadoEnum::values())],
            'fechaCreacion'=>'required|date',
            'fechaActualizacion'=>'required|date',
       ]);
          
    $entidad = entidad::findOrfail($id);
       $entidad->update($request->all());
       
    return redirect()->route('entidad.index')->with('success','Entidad Actualizada satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BitacoraHelper::registrar('Entidad', 'Eliminó la entidad con ID ' . $id);
        $entidad = entidad::findOrfail($id);
        $entidad->delete();
return redirect()->route('entidad.index')->with('success','Entidad Eliminada satisfactoriamente');

    }
}
