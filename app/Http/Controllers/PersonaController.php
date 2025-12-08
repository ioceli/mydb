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
    public function index(Request $request)
    {
        // Obtener todas las entidades para el filtro
        $entidades = Entidad::all();
        
        // Iniciar la consulta
        $query = User::with('entidad');
        
        // Aplicar filtros
        if ($request->has('estado') && $request->estado != '') {
            $query->where('estado', $request->estado);
        }
        
        if ($request->has('rol') && $request->rol != '') {
            $query->where('rol', $request->rol);
        }
        
        if ($request->has('entidad') && $request->entidad != '') {
            $query->where('idEntidad', $request->entidad);
        }
        
        // Filtrar por cédula o nombre (búsqueda general)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cedula', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('apellidos', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        // Ordenar por defecto
        $query->orderBy('name', 'asc');
        
        // Obtener registros por página
        $perPage = $request->per_page ?? 10;
        $usuarios = $query->paginate($perPage);
        
        // Obtener valores únicos para filtros
        $estados = EstadoEnum::values();
        $roles = RolEnum::values();
        
        // Pasar datos a la vista
        return view('persona.index', compact('usuarios', 'entidades', 'estados', 'roles', 'perPage'));
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
            'rol' => ['required', Rule::in(RolEnum::values())],
            'estado' => ['required', Rule::in(EstadoEnum::values())],
            'email' => 'required|email|unique:users,email',
            'genero' => ['required', Rule::in(GeneroEnum::values())],
            'telefono' => 'required|string|max:15',
            'password' => 'required|string|confirmed|min:8',
        ]);
        
        BitacoraHelper::registrar('Usuarios', 'Creó un nuevo usuario: ' . $request->name . ' ' . $request->apellidos);
        
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
        $usuario = User::findOrFail($id);
        $entidades = Entidad::all();
        return view('persona.edit', compact('usuario', 'entidades'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        
        BitacoraHelper::registrar('Usuarios', 'Actualizó al usuario con ID ' . $id);
        
        $request->validate([
            'idEntidad' => 'required|exists:entidad,idEntidad',
            'cedula' => [
                'required',
                'string',
                'size:10',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'cedula')->ignore($usuario->idUser, 'idUser'),
            ],
            'name' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'rol' => ['required', Rule::in(RolEnum::values())],
            'estado' => ['required', Rule::in(EstadoEnum::values())],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($usuario->idUser, 'idUser'),
            ],
            'genero' => ['required', Rule::in(GeneroEnum::values())],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
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

        return redirect()->route('persona.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $nombreCompleto = $usuario->name . ' ' . $usuario->apellidos;
        $usuario->delete();
        
        BitacoraHelper::registrar('Usuarios', 'Eliminó al usuario: ' . $nombreCompleto);
        
        return redirect()->route('persona.index')->with('success', 'Usuario eliminado correctamente.');
    }
    
    /**
     * Método para cambiar el estado de un usuario
     */
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => ['required', Rule::in(EstadoEnum::values())],
        ]);
        
        $usuario = User::findOrFail($id);
        $estadoAnterior = $usuario->estado;
        $usuario->estado = $request->estado;
        $usuario->save();
        
        BitacoraHelper::registrar('Usuarios', 'Cambió estado del usuario ' . $usuario->name . ' de ' . $estadoAnterior . ' a ' . $request->estado);
        
        return redirect()->route('persona.index')->with('success', 'Estado del usuario actualizado correctamente.');
    }
    
    /**
     * Método para cambiar el rol de un usuario
     */
    public function cambiarRol(Request $request, $id)
    {
        $request->validate([
            'rol' => ['required', Rule::in(RolEnum::values())],
        ]);
        
        $usuario = User::findOrFail($id);
        $rolAnterior = $usuario->rol;
        $usuario->rol = $request->rol;
        $usuario->save();
        
        BitacoraHelper::registrar('Usuarios', 'Cambió rol del usuario ' . $usuario->name . ' de ' . $rolAnterior . ' a ' . $request->rol);
        
        return redirect()->route('persona.index')->with('success', 'Rol del usuario actualizado correctamente.');
    }
}