@extends('layouts.master')
@section('title', 'Panel del Desarrollador')
@section('content')
<x-slot name="header">Panel del Desarrollador</x-slot>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>

    <ul class="list-disc ml-6 text-blue-700 space-y-2">
        <li><a href="{{ route('plan.index') }}">Ver Documentación Técnica del Sistema</a></li>
        <li><a href="{{ route('plan.index') }}">Atender Incidencias</a></li>
        <li><a href="{{ route('plan.index') }}">Desarrollar Funcionalidades</a></li>
    </ul>
</div>
@endsection