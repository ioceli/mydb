@extends('layouts.master')

<x-slot name="header">Panel del Revisor Institucional</x-slot>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>

    <ul class="list-disc ml-6 text-blue-700 space-y-2">
        <li><a href="{{ route('plan.index') }}">Verificar alineación con el Plan Nacional de Desarrollo</a></li>
        <li><a href="{{ route('plan.index') }}">Aprobar o Devolver Planes para Revisión</a></li>
    </ul>
</div>