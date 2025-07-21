@extends('layouts.master')
@section('title','Panel del Auditor')
@section('content')
{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR AUDITORIA--}}
<div class="container mx-auto p-4">
    <h2 class="text-center text-2xl font-bold mb-4">Bitácora del Auditor</h2>
    @if ($bitacoras->isEmpty())
        <div class="alert alert-info">
            No hay registros disponibles en la bitácora.
        </div>
    @else
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-200 text-gray-700 text-left">
                <tr>
                    <th class="p-2">Fecha</th>
                    <th class="p-2">Usuario</th>
                    <th class="p-2">Módulo</th>
                    <th class="p-2">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bitacoras as $registro)
                    <tr>
                        <td class="border px-4 py-2">{{ $registro->fecha }}</td>
                        <td class="border px-4 py-2">{{ $registro->usuario }}</td>
                        <td class="border px-4 py-2">{{ $registro->modulo }}</td>
                        <td class="border px-4 py-2">{{ $registro->accion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $bitacoras->links() }}
    @endif
    {{-- Botón para actualizar la vista --}}
</div>
<a href="{{route('dashboard.auditor')}}" class="btn btn-secondary text-white font-bold">VOLVER</a>
<a href="{{ route('auditoria.index') }}" class="btn btn-success">
        <i class="bi bi-eye"></i>Actualizar</a>
@endsection
