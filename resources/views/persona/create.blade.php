@extends('layouts.master') 
@section('title', 'Nueva Persona')
@section('content')

@php
    use App\Enums\RolEnum;
    use App\Enums\EstadoEnum;
    use App\Enums\GeneroEnum;
@endphp

<h2 class="text-xl font-bold mb-4">Registrar nuevo usuario</h2>

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <form method="POST" action="{{ route('persona.store') }}">
        @csrf

        <div class="mb-4">
            <label class="font-bold block mb-1">Entidad</label>
            <select name="idEntidad" class="w-full max-w-xl border rounded p-2">
                <option value="">Seleccione una entidad</option>
                @foreach ($entidades as $entidad)
                    <option value="{{ $entidad->idEntidad }}">{{ $entidad->subSector }}</option>
                @endforeach
            </select>
        </div>

        <input class="font-bold w-full mb-2 border rounded p-2" name="cedula" placeholder="Cédula" required>
        <input class="font-bold w-full mb-2 border rounded p-2" name="name" placeholder="Nombre" required>
        <input class="font-bold w-full mb-2 border rounded p-2" name="apellidos" placeholder="Apellidos" required>
        <input class="font-bold w-full mb-2 border rounded p-2" name="email" placeholder="Correo" required type="email">
        <input class="font-bold w-full mb-2 border rounded p-2" name="telefono" placeholder="Teléfono" required>

        <select name="genero" class="font-bold w-full mb-2 border rounded p-2">
            @foreach (GeneroEnum::values() as $genero)
                <option value="{{ $genero }}">{{ $genero }}</option>
            @endforeach
        </select>

        <select name="rol" class="font-bold w-full mb-2 border rounded p-2">
            @foreach (RolEnum::values() as $rol)
                <option value="{{ $rol }}">{{ $rol }}</option>
            @endforeach
        </select>

        <select name="estado" class="font-bold w-full mb-2 border rounded p-2">
            @foreach (EstadoEnum::values() as $estado)
                <option value="{{ $estado }}">{{ $estado }}</option>
            @endforeach
        </select>

        <input type="password" name="password" class="font-bold w-full mb-2 border rounded p-2" placeholder="Contraseña" required>
        <input type="password" name="password_confirmation" class="font-bold w-full mb-4 border rounded p-2" placeholder="Confirmar contraseña" required>

        <div class="flex justify-end space-x-2">
            <button class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">GUARDAR</button>
            <a href="{{ route('persona.index') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">VOLVER</a>
        </div>
    </form>
</div>
@endsection