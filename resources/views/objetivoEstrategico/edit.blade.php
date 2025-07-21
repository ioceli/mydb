@extends('layouts.master')
@section('title','Editar Objetivo Estrategico')
@section('content')
@php
    use App\Enums\EstadoEnum;
@endphp
<h2 class="text-xl font-bold mb-4">Editar Objetivo Estrategico</h2>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('objetivoEstrategico.update', $objetivoEstrategico->idObjetivoEstrategico) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <!-- Descripción -->
        <div>
            <label class="block font-bold mb-2">Descripción del Objetivo Estratégico</label>
            <input type="text" name="descripcion" required class="w-full border rounded p-2" value="{{ old('descripcion', $objetivoEstrategico->descripcion) }}">
        </div>
        <!-- ODS -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Alineación con Objetivos de Desarrollo Sostenible (ODS)</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach ($objetivoDesarrolloSostenible as $ods)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="ods_seleccionados[]" value="{{ $ods->idObjetivoDesarrolloSostenible }}"
                            {{ in_array($ods->idObjetivoDesarrolloSostenible, old('ods_seleccionados', $objetivoEstrategico->ods->pluck('idObjetivoDesarrolloSostenible')->toArray())) ? 'checked' : '' }}>
                        <span>{{ $ods->nombre }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <!-- OPND -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Alineación con Objetivos del Plan Nacional de Desarrollo (OPND)</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach ($objetivoPlanNacional as $opnd)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="opnd_seleccionados[]" value="{{ $opnd->idObjetivoPlanNacional }}"
                            {{ in_array($opnd->idObjetivoPlanNacional, old('opnd_seleccionados', $objetivoEstrategico->opnd->pluck('idObjetivoPlanNacional')->toArray())) ? 'checked' : '' }}>
                        <span>{{ $opnd->descripcion }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <!-- Fecha Registro -->
        <div>
            <label class="block font-bold mb-2">Fecha de Registro</label>
            <input type="date" name="fechaRegistro" required class="w-full border rounded p-2" value="{{ old('fechaRegistro', $objetivoEstrategico->fechaRegistro) }}">
        </div>
        <!-- Estado -->
        <div>
            <label class="block font-bold mb-2">Estado</label>
            <select name="estado" required class="w-full border rounded p-2">
                <option value="">Seleccione un estado</option>
                @foreach (EstadoEnum::cases() as $estado)
                    <option value="{{ $estado->value }}" {{ old('estado', $objetivoEstrategico->estado) === $estado->value ? 'selected' : '' }}>
                        {{ $estado->value }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Botones -->
        <div class="flex gap-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold">Actualizar</button>
            <a href="{{ route('objetivoEstrategico.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 font-bold">Cancelar</a>
        </div>
    </form>
</div>
@endsection