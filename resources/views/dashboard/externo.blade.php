@extends('layouts.master')
@section('title', 'Panel del Externo')
@section('content')
<div class="flex">
    {{-- Menú lateral --}}
    <aside class="w-64 bg-blue-100 h-auto p-4 shadow-md">
        <h3 class="text-lg font-bold mb-4">Menú Usuario externo</h3>
        <p class="mb-4 font-bold" >Acciones disponibles:</p>
            <ul class="list-disc ml-6 text-blue-700 space-y-2">
                <li><a href="{{ route('plan.index') }}"class="block p-2 rounded hover:bg-gray-200">Ingresar/Revisar Plan Institucional</a></li>
                <li><a href="{{ route('programa.index') }}"class="block p-2 rounded hover:bg-gray-200">Ingresar/Revisar Programa Institucional</a></li>
                <li><a href="{{ route('proyecto.index') }}"class="block p-2 rounded hover:bg-gray-200">Ingresar/Revisar Proyecto Institucional</a></li>
            </ul>
    </aside>
    {{-- Contenido principal --}}
    <div class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>
    </div>
</div>
@endsection