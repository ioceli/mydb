<?php
namespace App\Http\Controllers;
use App\Models\entidad;
use App\Helpers\BitacoraHelper;
use App\Models\metaEstrategica;
use App\Models\objetivoEstrategico;
use App\Models\plan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EstadoRevisionEnum;
use App\Enums\EstadoAutoridadEnum;
use Illuminate\Support\Facades\Auth;
class PlanController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        // 1. Obtener el ID de la Entidad del usuario logueado
        $idEntidad = Auth::user()->idEntidad; 
        // Obtener el rol del usuario necesario para lógica futura
        $role = Auth::user()->rol ?? null;
        // 2. Definir la consulta base filtrada por idEntidad
        $planesQuery = Plan::with(['entidad', 'objetivosEstrategicos', 'metasEstrategicas']);
        // Si NO es administrador, aplicar filtro por entidad
    if ($role !== 'Administrador del Sistema') {
        $planesQuery->where('idEntidad', $idEntidad);
    }
        // 3. Obtener los resultados
        $plan = $planesQuery->get();
        // 4. Manejo de resultados (si no hay planes para esa entidad)
        if ($plan->isEmpty() && $role !== 'Administrador del Sistema') {
            return view('plan.index', ['plan' => $plan, 'message' => 'No hay planes registrados para su Entidad.']);
        }
        // 5. Retornar la vista con los planes filtrados
        return view('plan.index', compact('plan'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $idEntidad = Auth::user()->idEntidad;
        $entidad = entidad::findOrFail($idEntidad);         
        $objetivoEstrategico = objetivoEstrategico::all();
        $metasEstrategicas = metaEstrategica::all();
        return view('plan.create', compact('entidad','objetivoEstrategico','metasEstrategicas') );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $idEntidad = Auth::user()->idEntidad; 
        $request->validate([
            'nombre'=>'required|string|unique:plan,nombre',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'idMetaEstrategica' => 'nullable|array',
        ]);
        BitacoraHelper::registrar('Plan', 'Creó un nuevo plan');
        $plan=plan::create([
            'idEntidad' => $idEntidad, 
            'nombre' => $request->nombre, 
            'estado_revision' => 'pendiente',
            'estado_autoridad' => 'pendiente',
        ]);
        // Asocia objetivos estratégicos al plan
        if ($request->has('idObjetivoEstrategico')) {
            $plan->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
        }
        // Asocia metas estratégicas al plan
        if ($request->has('idMetaEstrategica')) {
            $plan->metasEstrategicas()->sync($request->idMetaEstrategica);
        }
        return redirect()->route('plan.index')->with('success','Plan Creado satisfactoriamente');
    }
    /**
     * Display the specified resource.
     */
    public function show(plan $plan)
    {
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $plan = plan::with(['objetivosEstrategicos', 'metasEstrategicas'])->findOrFail($id);
        $entidad = Auth::user()->entidad;
        $objetivoEstrategico = objetivoEstrategico::all();
        $metasEstrategicas = metaEstrategica::all();
        return view('plan.edit',compact('plan','entidad','objetivoEstrategico','metasEstrategicas'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $idEntidad = Auth::user()->idEntidad; 
        $role = Auth::user()->rol ?? null;
        $plan = plan::findOrFail($id);
        if ($plan->idEntidad !== $idEntidad && $role !== 'Administrador del Sistema') {
             abort(403, 'Acceso no autorizado para actualizar este plan.');
        }
        $request->validate([
            'nombre'=>'required|string|unique:plan,nombre,' . $id . ',idPlan',
            'estado_revision'=>['nullable', Rule::in(EstadoRevisionEnum::values())],
            'estado_autoridad'=>['nullable', Rule::in(EstadoAutoridadEnum::values())],
            'idObjetivoEstrategico' => 'nullable|array',
            'idObjetivoEstrategico.*'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'idMetaEstrategica' => 'nullable|array',
        ]);
        BitacoraHelper::registrar('Plan', 'Actualizó el plan con ID ' . $id);
        $plan->update([
            'idEntidad' => $idEntidad,
            'nombre' => $request->nombre,
            'estado_revision' => 'pendiente',
            'estado_autoridad' => 'pendiente',
        ]);
        // Asocia objetivos estratégicos al plan
        if ($request->has('idObjetivoEstrategico')) {
            $plan->objetivosEstrategicos()->sync($request->idObjetivoEstrategico);
        }
        // Asocia metas estratégicas al plan
        if ($request->has('idMetaEstrategica')) {
            $plan->metasEstrategicas()->sync($request->idMetaEstrategica);
        }
        return redirect()->route('plan.index')->with('success','Plan Actualizado satisfactoriamente');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        BitacoraHelper::registrar('Plan', 'Eliminó el plan con ID ' . $id);
        $plan = plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('plan.index')->with('success','Plan Eliminado satisfactoriamente');
    }
}