<?php
namespace App\Http\Controllers;
use App\Models\ObjetivoPlanNacional;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\EjePndEnum;
class ObjetivoPlanNacionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $objetivoPlanNacional =objetivoPlanNacional::all(); 
        return view('objetivoPlanNacional.index',compact('objetivoPlanNacional'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('objetivoPlanNacional.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'codigo'=>'required|integer','unique:objetivoPlanNacional,codigo',
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            'ejePnd'=>['required', Rule::in(EjePndEnum::values())],
      ]);
       objetivoPlanNacional::create($request->all());
    return redirect()->route('objetivoPlanNacional.index')->with('success','Objetivo Plan Nacional Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(objetivoPlanNacional $objetivoPlanNacional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $objetivoPlanNacional = objetivoPlanNacional::findOrfail($id);
        return view('objetivoPlanNacional.edit',compact('objetivoPlanNacional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'codigo'=>'required|integer', $id . 'idObjetivoPlanNacional',
            'nombre'=>'required|string',
            'descripcion'=>'required|string',
            'ejePnd'=>['required',Rule::in(EjePndEnum::values())],
        ]);
       $objetivoPlanNacional = objetivoPlanNacional::findOrfail($id);
       $objetivoPlanNacional->update($request->all());
    return redirect()->route('objetivoPlanNacional.index')->with('success','Objetivo Plan Nacional Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objetivoPlanNacional = objetivoPlanNacional::findOrfail($id);
        $objetivoPlanNacional->delete();
return redirect()->route('objetivoPlanNacional.index')->with('success','Objetivo Plan Nacional Eliminado satisfactoriamente');
    }
}
