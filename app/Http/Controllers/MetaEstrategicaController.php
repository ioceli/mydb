<?php
namespace App\Http\Controllers;
use App\Models\metaEstrategica;
use App\Models\metaPlanNacional;
use App\Models\plan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetaEstrategicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $metas =metaEstrategica::with('plan.entidad','metasPlanNacional')->get(); 
             if ($metas->isEmpty()) {
        return view('metaEstrategica.index', ['metaEstrategica' => $metas, 'message' => 'No hay metas estratégicas registradas.']);
    }
        return view('metaEstrategica.index',compact('metas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $planes = plan::with('entidad')->get();
        $metaPlanNacional = metaPlanNacional::all();
        return view('metaEstrategica.create', compact('planes', 'metaPlanNacional'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'idPlan' => 'required|exists:plan,idPlan',
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            'fechaInicio'=>'required|date',
            'fechaFin'=>'required|date',
            'formulaIndicador'=>'required|string',
            'metaEsperada'=>'required|numeric',
            'progresoActual'=>'required|numeric',
            'tipoIndicador'=>'required|integer',        
            'unidadMedida'=>'required|string',        
        ]);

       $metaEstrategica=metaEstrategica::create([
        'idPlan' => $request->idPlan,
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'fechaInicio' => $request->fechaInicio,
        'fechaFin' => $request->fechaFin,
        'formulaIndicador' => $request->formulaIndicador,
        'metaEsperada' => $request->metaEsperada,
        'progresoActual' => $request->progresoActual,
        'tipoIndicador' => $request->tipoIndicador,
        'unidadMedida' => $request->unidadMedida,
    ]);
        // Asocia metas del Plan Nacional a la meta estratégica
        if ($request->has('idMetaPlanNacional')) {
            $metaEstrategica->metasPlanNacional()->sync($request->idMetaPlanNacional);
        }


    return redirect()->route('metaEstrategica.index')->with('success','Meta Estrategica Creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(metaEstrategica $metaEstrategica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
         $meta = metaEstrategica::findOrfail($id);
        $planes = Plan::all();
        $metaPlanNacional = MetaPlanNacional::all();
        return view('metaEstrategica.edit',compact('meta','planes','metaPlanNacional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idPlan' => 'required|exists:plan,idPlan',
            'nombre'=>'required|string', $id . 'idMetaEstrategica',
            'descripcion'=>'required|string',
            'fechaInicio'=>'required|date',
            'fechaFin'=>'required|date',
            'formulaIndicador'=>'required|string',
            'metaEsperada'=>'required|numeric',
            'progresoActual'=>'required|numeric',
            'tipoIndicador'=>'required|integer',        
            'unidadMedida'=>'required|string', 
            'metaPlanNacional' => 'nullable|array',
            'metaPlanNacional.*' => 'nullable|exists:meta_plan_nacional,idMetaPlanNacional',         
        ]);
       $meta = metaEstrategica::findOrfail($id);
       $meta->update([
        'idPlan' => $request->idPlan,
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'fechaInicio' => $request->fechaInicio,
        'fechaFin' => $request->fechaFin,
        'formulaIndicador' => $request->formulaIndicador,
        'metaEsperada' => $request->metaEsperada,
        'progresoActual' => $request->progresoActual,
        'tipoIndicador' => $request->tipoIndicador,
        'unidadMedida' => $request->unidadMedida,
    ]);
    // Asocia metas del Plan Nacional a la meta estratégica
    if ($request->has('metaPlanNacional')) {
        $meta->metasPlanNacional()->sync($request->metaPlanNacional);
    }

    return redirect()->route('metaEstrategica.index')->with('success','Meta Estrategica Actualizada satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $meta = metaEstrategica::findOrfail($id);
        $meta->delete();
        return redirect()->route('metaEstrategica.index')->with('success','Meta Estrategica Eliminada satisfactoriamente');
    }
}
