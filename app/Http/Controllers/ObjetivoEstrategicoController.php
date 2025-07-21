<?php
namespace App\Http\Controllers;
use App\Models\objetivoEstrategico;
use App\Helpers\BitacoraHelper;
use App\Models\objetivoPlanNacional;
use App\Models\objetivoDesarrolloSostenible;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EstadoEnum;

class ObjetivoEstrategicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $objetivoEstrategico = ObjetivoEstrategico::with(['ods', 'opnd'])->get();

    if ($objetivoEstrategico->isEmpty()) {
        return view('objetivoEstrategico.index', ['objetivoEstrategico' => $objetivoEstrategico, 'message' => 'No hay objetivos estratégicos registrados.']);
    }
    return view('objetivoEstrategico.index', compact('objetivoEstrategico'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
   {
    $objetivoDesarrolloSostenible = objetivoDesarrolloSostenible::all();
    $objetivoPlanNacional = objetivoPlanNacional::all();

    return view('objetivoEstrategico.create', compact(
        'objetivoDesarrolloSostenible',
        'objetivoPlanNacional'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        BitacoraHelper::registrar('ObjetivoEstrategico', 'Creó un nuevo objetivo estratégico');
          $request->validate([
        'descripcion' => 'required|string|unique:objetivo_estrategico,descripcion',
        'fechaRegistro' => 'required|date',
        'estado' => ['required', Rule::in(EstadoEnum::values())],
        'ods_seleccionados' => 'nullable|array',
        'ods_seleccionados.*' => 'exists:objetivo_desarrollo_sostenible,idObjetivoDesarrolloSostenible',
        'opnd_seleccionados' => 'nullable|array',
        'opnd_seleccionados.*' => 'exists:objetivo_plan_nacional,idObjetivoPlanNacional',
             
      ]);
       $objetivo=objetivoEstrategico::create([
           
            'descripcion' => $request->descripcion,
    'fechaRegistro' => $request->fechaRegistro,
    'estado' => $request->estado,
]);

if ($request->filled('ods_seleccionados')) {
    $objetivo->ods()->attach($request->ods_seleccionados);
}

if ($request->filled('opnd_seleccionados')) {
    $objetivo->opnd()->attach($request->opnd_seleccionados);
}
    


    return redirect()->route('objetivoEstrategico.index')->with('success','Objetivo Estrategico Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(objetivoEstrategico $objetivoEstrategico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit($id)
{
    $objetivoEstrategico = objetivoEstrategico::with(['ods', 'opnd'])->findOrFail($id);
    $objetivoDesarrolloSostenible = objetivoDesarrolloSostenible::all();
    $objetivoPlanNacional = objetivoPlanNacional::all();

    return view('objetivoEstrategico.edit', compact(
        'objetivoEstrategico',
        'objetivoDesarrolloSostenible',
        'objetivoPlanNacional'
    ));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    BitacoraHelper::registrar('ObjetivoEstrategico', 'Actualizó un objetivo estratégico con ID ' . $id);
    $request->validate([
        'descripcion' => [
            'required',
            'string',
            Rule::unique('objetivo_estrategico', 'descripcion')->ignore($id, 'idObjetivoEstrategico'),
        ],
        'fechaRegistro' => 'required|date',
        'estado' => ['required', Rule::in(EstadoEnum::values())],
        'ods_seleccionados' => 'nullable|array',
        'ods_seleccionados.*' => 'exists:objetivo_desarrollo_sostenible,idObjetivoDesarrolloSostenible',
        'opnd_seleccionados' => 'nullable|array',
        'opnd_seleccionados.*' => 'exists:objetivo_plan_nacional,idObjetivoPlanNacional',
    ]);

    $objetivoEstrategico = objetivoEstrategico::findOrFail($id);

    $objetivoEstrategico->update([
        'descripcion' => $request->descripcion,
        'fechaRegistro' => $request->fechaRegistro,
        'estado' => $request->estado,
    ]);

    // Actualizar relaciones ODS y OPND (muchos a muchos)
    $objetivoEstrategico->ods()->sync($request->ods_seleccionados ?? []);
    $objetivoEstrategico->opnd()->sync($request->opnd_seleccionados ?? []);

    return redirect()->route('objetivoEstrategico.index')
        ->with('success', 'Objetivo Estratégico actualizado satisfactoriamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BitacoraHelper::registrar('ObjetivoEstrategico', 'Eliminó un objetivo estratégico con ID ' . $id);
        $objetivoEstrategico = objetivoEstrategico::findOrfail($id);
        $objetivoEstrategico->delete();
return redirect()->route('objetivoEstrategico.index')->with('success','Objetivo Estrategico Eliminado satisfactoriamente');
    }
}
