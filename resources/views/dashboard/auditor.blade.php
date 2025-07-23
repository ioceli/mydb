@extends('layouts.master')

@section('title', 'Panel del Auditor')

@section('content')
<div class="flex">
    {{-- Menú lateral --}}
    <aside class="w-64 bg-blue-100 h-auto p-4 shadow-md">
        <h3 class="text-lg font-bold mb-4">Menú Auditor</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('auditoria.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Consultar Bitácoras
                </a>
            </li>
            <li>
                <a href="{{ route('auditoria.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Generar Reportes
                </a>
            </li>
            <li>
                <a href="{{ route('auditoria.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Historial de Versiones
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