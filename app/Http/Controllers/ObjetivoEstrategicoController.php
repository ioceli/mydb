<?php
namespace App\Http\Controllers;
use App\Models\objetivoEstrategico;
use App\Models\plan;
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
         $objetivoEstrategico =objetivoEstrategico::all(); 
        return view('objetivoEstrategico.index',compact('objetivoEstrategico'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('objetivoEstrategico.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'descripcion'=>'required|string|unique:objetivo_estrategico,descripcion',
            'fechaRegistro'=>'required|date',
            'estado'=>['required', Rule::in(EstadoEnum::values())],
             'idPlan' => 'nullable|exists:plan,idPlan',
      ]);
       objetivoEstrategico::create($request->all());
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
         $objetivoEstrategico = objetivoEstrategico::findOrfail($id);
         $plan = plan::all();
           return view('objetivoEstrategico.edit',compact('objetivoEstrategico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idPlan'=>'required|exists:plan,idPlan',
            'descripcion'=>'required|string', $id . 'idObjetivoEstrategico',
            'fechaRegistro'=>'required|date',
            'estado'=>['required',Rule::in(EstadoEnum::values())],
        ]);
       $objetivoEstrategico = objetivoEstrategico::findOrfail($id);
       $objetivoEstrategico->update([
       'idPlan' => $request->idPlan,
        'descripcion' => $request->descripcion,
        'fechaRegistro' => $request->fechaRegistro,
        'estado' => $request->estado,
       ]);
    return redirect()->route('objetivoEstrategico.index')->with('success','Objetivo Estrategico Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objetivoEstrategico = objetivoEstrategico::findOrfail($id);
        $objetivoEstrategico->delete();
return redirect()->route('objetivoEstrategico.index')->with('success','Objetivo Estrategico Eliminado satisfactoriamente');
    }
}
