<?php

namespace App\Http\Controllers;

use App\Models\persona;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Enums\RolEnum;
use App\Enums\EstadoEnum;
use App\Enums\GeneroEnum;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $persona =persona::all(); 
        return view('persona.index',compact('persona'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('persona.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'cedula'=>['required', 'string', 'size:10', 'regex:/^[0-9]+$/', 'unique:persona,cedula'],
            'nombres'=>'required|string',
            'apellidos'=>'required|string',
            'rol'=> ['required', Rule::in(RolEnum::values())],
            'estado'=>['required',Rule::in(EstadoEnum::values())],
            'correo'=>['required', 'email', 'unique:persona,correo'],
            'genero'=>['required',Rule::in(GeneroEnum::values())],
            'telefono'=>['required', 'string', 'regex:/^[0-9]+$/', 'min:9', 'max:15'],
            'contraseña'=>['required', 'string', 'min:8'],
       ]);
       persona::create($request->all());
    return redirect()->route('persona.index')->with('success','Persona Creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $persona = persona::findOrfail($id);
        return view('persona.edit',compact('persona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Buscar la persona por su ID
    $persona = Persona::findOrFail($id);

    // Validar datos
    $validatedData = $request->validate([
        'cedula' => ['required','string','size:10','regex:/^[0-9]+$/',
        Rule::unique('persona', 'cedula')->ignore($persona->idPersona, 'idPersona'),],
        'nombres' => ['required', 'string'],
        'apellidos' => ['required', 'string'],
         'rol'=> ['required', Rule::in(RolEnum::values())],
        'estado'=>['required',Rule::in(EstadoEnum::values())],
            'correo' => ['required','email',
            Rule::unique('persona', 'correo')->ignore($persona->idPersona, 'idPersona'),],
        'genero'=>['required',Rule::in(GeneroEnum::values())],
        'telefono' => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
        'contraseña' => ['nullable', 'string', 'min:8'],
    ]);

    // Asignar valores
    $persona->cedula = $validatedData['cedula'];
    $persona->nombres = $validatedData['nombres'];
    $persona->apellidos = $validatedData['apellidos'];
    $persona->rol = $validatedData['rol'];
    $persona->estado = $validatedData['estado'];
    $persona->correo = $validatedData['correo'];
    $persona->genero = $validatedData['genero'];
    $persona->telefono = $validatedData['telefono'];
    $persona->contraseña = $validatedData['contraseña'];

    // Guardar cambios
    $persona->save();

    return redirect()->route('persona.index')->with('success', 'Persona actualizada correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $persona = persona::findOrfail($id);
        $persona->delete();
return redirect()->route('persona.index')->with('success','Persona Eliminada satisfactoriamente');
    }
}
