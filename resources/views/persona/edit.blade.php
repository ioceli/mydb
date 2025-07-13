@extends('layouts.master')
@section('title', 'Editar Usuario')
@php
    use App\Enums\RolEnum;
    use App\Enums\EstadoEnum;
    use App\Enums\GeneroEnum;
@endphp
@section('content')
@if ($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $error )
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h2 class="font-bold text-xl font-bold mb-4">Editar usuario</h2>
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
<form action="{{ route('persona.update', $usuario->idUser) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label class="font-bold block mb-1">Entidad</label>
        <select name="idEntidad" class="w-full border rounded p-2">
            <option value="">Seleccione una entidad</option>
            @foreach ($entidades as $entidad)
                <option value="{{ $entidad->idEntidad }}" {{ $usuario->idEntidad == $entidad->idEntidad ? 'selected' : '' }}>
                    {{ $entidad->subSector }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <input type="text" name="cedula" class="font-bold w-full border rounded p-2" placeholder="Cédula"
               value="{{ old('cedula', $usuario->cedula) }}" required>
    </div>

    <div class="mb-4">
        <input type="text" name="name" required class="font-bold w-full border rounded p-2" placeholder="Nombre"
               value="{{ old('name', $usuario->name) }}" >
    </div>

    <div class="mb-4">
        <input type="text" name="apellidos" required class="font-bold w-full border rounded p-2" placeholder="Apellidos"
               value="{{ old('apellidos', $usuario->apellidos) }}" >
    </div>

    <div class="mb-4">
        <input type="email" name="email" required class="font-bold w-full border rounded p-2" placeholder="Correo"
               value="{{ old('email', $usuario->email) }}">
    </div>

    <div class="mb-4">
        <input type="text" name="telefono" required class="font-bold w-full border rounded p-2" placeholder="Teléfono"
               value="{{ old('telefono', $usuario->telefono) }}" >
    </div>

    <div class="mb-4">
        <label class="font-bold block mb-1">Género</label>
        <select name="genero" class="w-full border rounded p-2">
            @foreach (GeneroEnum::values() as $genero)
                <option value="{{ $genero }}" {{ $usuario->genero === $genero ? 'selected' : '' }}>
                    {{ $genero }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="font-bold block mb-1">Rol</label>
        <select name="rol" class="w-full border rounded p-2">
            @foreach (RolEnum::values() as $rol)
                <option value="{{ $rol }}" {{ $usuario->rol === $rol ? 'selected' : '' }}>
                    {{ $rol }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="font-bold block mb-1">Estado</label>
        <select name="estado" class="w-full border rounded p-2">
            @foreach (EstadoEnum::values() as $estado)
                <option value="{{ $estado }}" {{ $usuario->estado === $estado ? 'selected' : '' }}>
                    {{ $estado }}
                </option>
            @endforeach
        </select>
    </div>
<input type="password" name="password" class="font-bold w-full mb-2 border rounded p-2" placeholder="Contraseña" required>
    <div class="flex gap-4">
        <button type="submit" class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">ACTUALIZAR</button>
        <a href="{{ route('persona.index') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">CANCELAR</a>
    </div>
</form>
 </div>
@endsection