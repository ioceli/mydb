@extends('layouts.master')
@section('title', 'Panel del Administrador')
@section('content')
<x-slot name="header">Panel del Administrador</x-slot>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>
    <p class="mb-4">Usted puede gestionar los usuarios y entidades del sistema.</p>

    <ul class="list-disc ml-6 text-blue-700 space-y-2">
        <li><a href="{{ route('profile.edit') }}">Gestión de Usuarios</a></li>
        <li><a href="{{ route('entidad.index') }}">Gestión de Entidades</a></li>
    </ul>
</div>
@endsection