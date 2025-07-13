<?php
namespace App\Http\Controllers;
use App\Models\entidad;
use App\Models\objetivoEstrategico;
use App\Models\plan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EstadoEnum;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $plan =plan::all(); 
         $objetivoEstrategico = objetivoEstrategico::all();
        return view('plan.index',compact('plan','objetivoEstrategico'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entidad = entidad::all();
        $objetivoEstrategico = objetivoEstrategico::all();
               return view('plan.create', compact('entidad','objetivoEstrategico') );
      }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
          $request->validate([
            'idEntidad'=>'nullable|exists:entidad,idEntidad',
            'idObjetivoEstrategico'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'nombre'=>'required|string|unique:plan,nombre',
            'estado'=>['required', Rule::in(EstadoEnum::values())],
      ]);
  
        plan::create([
        'idEntidad' => $request->idEntidad,
        'idObjetivoEstrategico' => $request->idObjetivoEstrategico,
        'nombre' => $request->nombre,
        'estado' => $request->estado,
    ]);
    return redirect()->route('plan.index')->with('success','Plan Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $plan = plan::findOrfail($id);
        $entidad = entidad::all();
        $objetivoEstrategico = objetivoEstrategico::all();
                return view('plan.edit',compact('plan','entidad','objetivoEstrategico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idEntidad'=>'nullable|exists:entidad,idEntidad',
            'idObjetivoEstrategico'=>'nullable|exists:objetivo_estrategico,idObjetivoEstrategico',
            'nombre'=>'required|string', $id . 'idPLan',
            'estado'=>['required',Rule::in(EstadoEnum::values())],
        ]);
       $plan = plan::findOrfail($id);
     $plan->update([
        'idEntidad' => $request->idEntidad,
        'idObjetivoEstrategico' => $request->idObjetivoEstrategico,
        'nombre' => $request->nombre,
        'estado' => $request->estado,
    ]);
    return redirect()->route('plan.index')->with('success','Plan Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $plan = plan::findOrfail($id);
        $plan->delete();
return redirect()->route('plan.index')->with('success','Plan Eliminado satisfactoriamente');
    }
}
