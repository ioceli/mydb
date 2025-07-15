@extends('layouts.master')
@section('title','Nuevo Objetivo Estrategico')
@section('content')
@php
    use App\Enums\EstadoEnum;
@endphp 
<h2 class="text-xl font-bold mb-4">Registrar nuevo Objetivo Estrategico</h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
{{--FORMULARIO PARA LA CREACION DE OBJETIVO ESTRATEGICO--}}
<form action="{{ route ('objetivoEstrategico.store')}} "method="POST" class="space-y-4">
    @csrf
<div class="mb-4">
    <label class="block font-bold mb-2">Objetivos de Desarrollo Sostenible (ODS)</label>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        @foreach ($objetivoDesarrolloSostenible as $ods)
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="ods_seleccionados[]" value="{{ $ods->idObjetivoDesarrolloSostenible }}"
                    {{ is_array(old('ods_seleccionados')) && in_array($ods->idObjetivoDesarrolloSostenible, old('ods_seleccionados')) ? 'checked' : '' }}>
                <span>{{ $ods->nombre }}</span>
            </label>
        @endforeach
    </div>
</div>
<div class="mb-4">
                    <label for="opnd_seleccionados" class="w-full max-w-xl mb-2 font-bold">OBJETIVO PLAN NACIONAL</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach ($objetivoPlanNacional as $opnd)
                      <label class="flex items-center space-x-2">
                        <input type="checkbox" name="opnd_seleccionados[]" value="{{ $opnd->idObjetivoPlanNacional }}"
                            {{ is_array(old('opnd_seleccionados')) && in_array($opnd->idObjetivoPlanNacional, old('opnd_seleccionados')) ? 'checked' : '' }}>
                        <span>{{ $opnd->nombre }}</span>
                        </label>
                    @endforeach
</div>
                </div>
        <div>
            <label class="w-full max-w-xl mb-2 font-bold">DESCRIPCION</label>
            <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required>
        </div>
        <div>
            <label class="w-full max-w-xl mb-2 font-bold">FECHA REGISTRO</label>
            <input class="w-full max-w-xl mb-2 border rounded p-2" type="date" name="fechaRegistro" required>
        </div>
        <div>
            <label class="w-full max-w-xl mb-2 font-bold">ESTADO</label>
                <select class="w-full max-w-xl mb-2 border rounded p-2" name="estado" required>
                    <option value="">Seleccione un estado</option>
                        @foreach (EstadoEnum::cases() as $estado)
                            <option value="{{ $estado->value }}" {{ old('estado') === $estado->value ? 'selected' : '' }}>
                                {{ $estado->value }}
                            </option>
                        @endforeach
                </select>
        </div>
            <button type="submit" class="btn btn-success font-bold">GUARDAR</button>
            <a href="{{route('objetivoEstrategico.index')}}"class="btn btn-secondary text-white font-bold">VOLVER</a>
</form>
@endsection