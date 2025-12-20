@extends('layouts.master')
@section('title','Editar Entidad')
@php
    use App\Enums\EstadoEnum;
@endphp
@section('content')
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
<h2 class="text-2x1 font-bold mb-4"> EDITAR ENTIDADES   </h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{route ('entidad.update', $entidad->idEntidad )}}"method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="font-bold block mb-1">Codigo</label>
                <input type="number" name="codigo" class="w-full border rounded p-2" required value="{{old('codigo', $entidad->codigo)}}">
            </div>
            <div>
                <label class="font-bold block mb-1">Subsector</label>
                <input type="text" name="subSector" class="w-full border rounded p-2" required value="{{old('subSector', $entidad->subSector)}}">
            </div>
            <div>
                <label class="font-bold block mb-1">Nivel de Gobierno</label>
                <input type="text" name="nivelGobierno" class="w-full border rounded p-2" required value="{{old('nivelGobierno', $entidad->nivelGobierno)}}">
            </div>
            <div>
                <label class="font-bold block mb-1">ESTADO</label>
                <select name="estado" class="w-full border rounded p-2" required>
                    <option value="">Seleccione un estado</option>
                    @foreach (EstadoEnum::cases() as $estado)
                        <option value="{{ $estado->value }}" {{ old('estado',  $persona->estado ??'') === $estado->value? 'selected' : '' }}>
                        {{ $estado->value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-bold block mb-1">Fecha de Creacion</label>
                <input type="date" name="fechaCreacion" class="w-full border rounded p-2" required value="{{old('fechaCreacion', $entidad->fechaCreacion)}}">
            </div>
            <div>
                <label class="font-bold block mb-1">Fecha de Actualizacion</label>
                <input type="date" name="fechaActualizacion" class="w-full border rounded p-2" required value="{{old('fechaActualizacion', $entidad->fechaActualizacion)}}">
            </div>
            <div class="flex gap-4">
                <button type="submit" class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">ACTUALIZAR</button>

                <a href="{{route('entidad.index')}}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">CANCELAR</a>
            </div>
        </form>
</div>
    @endsection