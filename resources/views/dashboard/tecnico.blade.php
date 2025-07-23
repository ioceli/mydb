@extends('layouts.master')
@section('title', 'Panel del Tecnico')
@section('content')
<div class="flex">
    {{-- Menú lateral --}}
    <aside class="w-64 bg-blue-100 h-auto p-4 shadow-md">
        <h3 class="text-lg font-bold mb-4">Menú Técnico</h3>
             <p class="mb-4 font-bold" >Acciones disponibles:</p>
                <ul class="list-disc ml-6 text-blue-700 space-y-2">
                    <li><a href="{{ route('metaEstrategica.index') }}"class="block p-2 rounded hover:bg-gray-200">Cargar Metas Estratégicas</a></li>
                    <li><a href="{{ route('metaPlanNacional.index') }}"class="block p-2 rounded hover:bg-gray-200">Cargar Metas Plan Nacional</a></li>
                    <li><a href="{{ route('indicador.index') }}"class="block p-2 rounded hover:bg-gray-200">Cargar Indicadores</a></li>
                </ul>   

    </aside>
  {{-- Contenido principal --}}
    <div class="flex-1 p-6">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>
    </div>
</div>
@endsection