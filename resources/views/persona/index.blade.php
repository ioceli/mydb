@extends('layouts.master')
@section('title', 'Gestión de Usuarios')
@section('content')

<h2 class="text-2xl font-bold mb-4">Usuarios Registrados</h2>

@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('persona.create') }}" class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nuevo Usuario</a>

<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Entidad</th>
                <th class="p-2">Cedula</th>
                <th class="p-2">Nombres</th>
                <th class="p-2">Apellidos</th>
                <th class="p-2">Rol</th>
                <th class="p-2">Estado</th>
                <th class="p-2">Correo</th>
                <th class="p-2">Genero</th>
                <th class="p-2">Telefono</th>
                <th class="p-2">Contraseña</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr class="border-b">
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->idUser }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->entidad->subSector ?? 'Sin entidad' }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->cedula }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->name }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->apellidos }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->rol }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->estado }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->email }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->genero }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->telefono }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{ $usuario->password }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('persona.edit', $usuario->idUser) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>
                        <form method="POST" action="{{ route('persona.destroy', $usuario->idUser) }}" onsubmit="return confirm('¿Está seguro de eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">
<a href="{{ route('dashboard.admin') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
@endsection
