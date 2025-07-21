@extends('layouts.master')
@section('title', 'Panel del Tecnico')
@section('content')
<x-slot name="header">Panel del Técnico de Planificación</x-slot>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>
    <p class="mb-4">Acciones disponibles:</p>

    <ul class="list-disc ml-6 text-blue-700 space-y-2">
        
        <li><a href="{{ route('metaEstrategica.index') }}">Cargar Metas Estratégicas</a></li>
        <li><a href="{{ route('metaPlanNacional.index') }}">Cargar Metas Plan Nacional</a></li>
        <li><a href="{{ route('indicador.index') }}">Cargar Indicadores</a></li>
        
    </ul>
</div>
@endsection