<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Helpers\BitacoraHelper;
use App\Models\Entidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Enums\EstadoEnum;
use App\Enums\RolEnum;
use App\Enums\GeneroEnum;
class PersonaController extends Controller
{
public function index()
{
    $usuarios = User::all();
    return view('persona.index', compact('usuarios'));
}
    public function create()
{
    $entidades = Entidad::all();
    return view('persona.create', compact('entidades'));
}

public function store(Request $request)
{
    $request->validate([
        'idEntidad' => 'required|exists:entidad,idEntidad',
        'cedula' => 'required|string|size:10|unique:users',
        'name' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'rol' => 'required|string',
        'estado' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'genero' => 'required|string',
        'telefono' => 'required|string|max:15',
        'password' => 'required|string|confirmed|min:8',
    ]);
    BitacoraHelper::registrar('Usuarios', 'Creó un nuevo usuario');
    User::create([
        'idEntidad' => $request->idEntidad,
        'cedula' => $request->cedula,
        'name' => $request->name,
        'apellidos' => $request->apellidos,
        'rol' => $request->rol,
        'estado' => $request->estado,
        'email' => $request->email,
        'genero' => $request->genero,
        'telefono' => $request->telefono,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('persona.index')->with('success', 'Usuario creado correctamente.');
}

public function edit($id)
{
    $usuario = User ::findOrfail($id);
    $entidades = Entidad::all();
    return view('persona.edit', compact('usuario', 'entidades'));
}

public function update(Request $request, $id)
{
       // Buscar la persona por su ID
    $usuario = User::findOrFail($id);
     BitacoraHelper::registrar('Usuarios', 'Actualizó al usuario con ID ' . $id);
    // Validar datos
    $request->validate([
        'idEntidad'=>'required|exists:entidad,idEntidad',
        'cedula' => ['required','string','size:10','regex:/^[0-9]+$/',
        Rule::unique('users', 'cedula')->ignore($usuario->idUser, 'idUser'),],
        'name' => ['required', 'string'],
        'apellidos' => ['required', 'string'],
         'rol'=> ['required', Rule::in(RolEnum::values())],
        'estado'=>['required',Rule::in(EstadoEnum::values())],
            'email' => ['required','email',
            Rule::unique('users', 'email')->ignore($usuario->idUser, 'idUser'),],
        'genero'=>['required',Rule::in(GeneroEnum::values())],
        'telefono' => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
        'password' => ['required', 'string', 'min:8'],
    ]);
 // Actualizar campos
    $usuario->idEntidad = $request->idEntidad;
    $usuario->cedula = $request->cedula;
    $usuario->name = $request->name; 
    $usuario->apellidos = $request->apellidos;
    $usuario->rol = $request->rol;
    $usuario->estado = $request->estado;
    $usuario->email = $request->email;
    $usuario->genero = $request->genero;
    $usuario->telefono = $request->telefono;

    if ($request->filled('password')) {
        $usuario->password = Hash::make($request->password);
    }
    
    $usuario->save(); 


   return redirect()->route('persona.index')->with('success', 'Persona actualizada correctamente.');
}
public function destroy($id)
{
    $usuario = User::findOrFail($id);
    $usuario->delete();
    BitacoraHelper::registrar('Usuarios', 'Eliminó al usuario con ID ' . $id);
    return redirect()->route('persona.index')->with('success', 'Usuario eliminado correctamente.');
}
}