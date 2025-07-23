@extends('layouts.master')

@section('title', 'Panel del Administrador')

@section('content')
<div class="flex">
    {{-- Menú lateral --}}
    <aside class="w-64 bg-blue-100 h-auto p-4 shadow-md">
        <h3 class="text-lg font-bold mb-4">Menú Administrador</h3>
        <p class="mb-4 font-bold" >Acciones disponibles:</p>
        <ul class="list-disc ml-6 space-y-2 text-blue-700">
            <li>
                <a href="{{ route('persona.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Gestión de Usuarios
                </a>
            </li>
            <li>
                <a href="{{ route('entidad.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Gestión de Entidades
                </a>
            </li>
            <li>
                <a href="{{ route('objetivoDesarrolloSostenible.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Gestión de Objetivos ODS
                </a>
            </li>
            <li>
                <a href="{{ route('objetivoPlanNacional.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Gestión de Objetivos PND
                </a>
            </li>
            <li>
                <a href="{{ route('objetivoEstrategico.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Gestión de Objetivos EStratégicos
                </a>
            </li>
        </ul>
    </aside>
    {{-- Contenido principal --}}
    <div class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>
    </div>
</div>
@endsection