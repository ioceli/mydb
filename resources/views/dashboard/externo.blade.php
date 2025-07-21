@extends('layouts.master')
@section('title', 'Panel del Externo')
@section('content')
<x-slot name="header">Panel del Usuario Externo</x-slot>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-bold mb-4 text-orange-600">Bienvenido, {{ Auth::user()->name }}</h2>

    <ul class="list-disc ml-6 text-blue-700 space-y-2">
        <li><a href="{{ route('plan.index') }}">Ingresar/Revisar Plan Institucional</a></li>
         <li><a href="{{ route('programa.index') }}">Ingresar/Revisar Programa Institucional</a></li>
          <li><a href="{{ route('proyecto.index') }}">Ingresar/Revisar Proyecto Institucional</a></li>
    </ul>
</div>
@endsection