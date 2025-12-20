@extends('layouts.master')
@section('title','Nueva Entidad')
@section('content')
@php
    use App\Enums\EstadoEnum;
@endphp
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-admin-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
{{--VALIDACION--}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
<h2 class="text-xl font-bold mb-4">Registrar nueva entidad</h2>
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
{{--FORMULARIO PARA LA CREACION DE ENTIDADES--}}
<form method="POST" action="{{ route ('entidad.store')}}">
    @csrf
<div class="mb-4">
    <label class="font-bold w-full max-w-xl mb-2 ">Codigo</label>
     <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="codigo" placeholder="Código" required>
</div>
<div>
    <label class="font-bold w-full max-w-xl mb-2 ">SubSector</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="subSector" required>
</div>
<div>
    <label class="font-bold w-full max-w-xl mb-2 ">Nivel de Gobierno</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nivelGobierno" required>
</div>
<div>
    <label class="font-bold w-full max-w-xl mb-2 ">ESTADO</label>
     <select class="w-full max-w-xl mb-2 border rounded p-2" name="estado" required>
 <option value="">Seleccione un estado</option>
        @foreach (EstadoEnum::cases() as $estado)
            <option value="{{ $estado->value }}" {{ old('estado') === $estado->value ? 'selected' : '' }}>
                {{ $estado->value }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label class="font-bold w-full max-w-xl mb-2 ">Fecha de Creacion</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="date" name="fechaCreacion" required>
</div>
<div>
    <label class="font-bold w-full max-w-xl mb-2 ">Fecha de Actualizacion</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="date" name="fechaActualizacion" required>
</div>
<div class="flex justify-end space-x-2">
<button type="submit" class="font-bold btn btn-success">GUARDAR</button>
<a href="{{ route('entidad.index') }}" class="font-bold btn btn-secondary text-white">VOLVER</a>
</div>
</form>
</div>
@endsection