@extends('layouts.master')
@section('title','Nuevo Plan')
@section('content')
@php
    use App\Enums\EstadoRevisionEnum;
@endphp
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-dynamic-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
    {{--VALIDACION--}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
<h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">Registrar Nuevo Plan Estratégico</h2>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
    {{-- FORMULARIO PARA LA CREACION DE PLANES --}}
    <form action="{{ route ('plan.store')}} "method="POST" class="space-y-6">
        @csrf
        {{-- CAMPO ENTIDAD (BLOQUEADO) --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">ENTIDAD ASIGNADA</label>
            {{-- Muestra el nombre de la entidad (subSector) del usuario logueado en un campo de solo lectura --}}
            <input 
                class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100 text-gray-600 cursor-not-allowed" type="text" value="{{ $entidad->subSector }}" readonly aria-describedby="entidad-info">
            <p id="entidad-info" class="mt-1 text-xs text-blue-600">Este plan se asociará automáticamente a su entidad.</p>
            {{-- CAMPO OCULTO: Ya que el controlador ahora toma el idEntidad del Auth::user(), este campo ya NO es estrictamente necesario, pero lo dejaré comentado por si acaso el controlador necesita esa información en el request. (En el controlador anterior que modifiqué, el ID ya no se toma del request, así que lo puedes omitir) --}}
            {{-- <input type="hidden" name="idEntidad" value="{{ $entidad->idEntidad }}"> --}}
        </div>
        {{-- CAMPO NOMBRE DEL PLAN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2" for="nombre">NOMBRE DEL PLAN</label>
            <input 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Plan de Transformación Digital 2024" required>
        </div>
        {{-- ALINEACIÓN CON OBJETIVOS ESTRATÉGICOS --}}
        <div class="p-4 border border-indigo-200 rounded-lg bg-indigo-50">
            <label class="block text-sm font-bold text-indigo-700 mb-3" for="idObjetivoEstrategico">Alineación con Objetivos Estratégicos</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($objetivoEstrategico as $objetivo)
                    <label class="flex items-center space-x-3 bg-white p-3 rounded-md shadow-sm hover:bg-indigo-100 transition duration-150">
                        <input type="checkbox" 
                            name="idObjetivoEstrategico[]" 
                            value="{{ $objetivo->idObjetivoEstrategico }}"
                            class="form-checkbox h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            {{ (is_array(old('idObjetivoEstrategico')) && in_array($objetivo->idObjetivoEstrategico, old('idObjetivoEstrategico'))) ? 'checked' : '' }}
                        >
                        <span class="text-sm font-medium text-gray-800">{{ $objetivo->descripcion }}</span>
                    </label>
                @empty
                    <p class="col-span-2 text-gray-500 italic">No hay objetivos estratégicos disponibles para alinear.</p>
                @endforelse
            </div>
        </div>
        {{-- ALINEACIÓN CON METAS ESTRATÉGICAS --}}
        <div class="p-4 border border-teal-200 rounded-lg bg-teal-50">
            <label class="block text-sm font-bold text-teal-700 mb-3" for="idMetaEstrategica">Alineación con Metas Estratégicas</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($metasEstrategicas as $meta)
                    <label class="flex items-center space-x-3 bg-white p-3 rounded-md shadow-sm hover:bg-teal-100 transition duration-150">
                        <input type="checkbox" name="idMetaEstrategica[]" value="{{ $meta->idMetaEstrategica }}" class="form-checkbox h-5 w-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                            {{ (is_array(old('idMetaEstrategica')) && in_array($meta->idMetaEstrategica, old('idMetaEstrategica'))) ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-800">{{ $meta->descripcion }}</span>
                    </label>
                @empty
                     <p class="col-span-2 text-gray-500 italic">No hay metas estratégicas disponibles para alinear.</p>
                @endforelse
            </div>
        </div>
        {{-- BOTONES --}}
        <div class="flex justify-start space-x-4 pt-4">
            <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                GUARDAR
            </button>
                        <a href="{{ route('plan.index') }}" class="inline-flex justify-center py-3 px-6 font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">CANCELAR</a>
        </div>
    </form>
</div>
        </div>
    </div>
</div>
@endsection