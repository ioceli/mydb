@extends('layouts.master')

<x-slot name="header">Panel del Auditor</x-slot>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>

    <ul class="list-disc ml-6 text-blue-700 space-y-2">
        <li><a href="{{ route('auditoria.index') }}">Consultar Bitácoras del Sistema</a></li>
        <li><a href="{{ route('auditoria.index') }}">Generar Reportes de Control</a></li>
        <li><a href="{{ route('auditoria.index') }}">Ver Historial de Versiones y Aprobaciones</a></li>
    </ul>
</div>