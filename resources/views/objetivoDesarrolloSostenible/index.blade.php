@extends('layouts.master')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Objetivo Desarrollo Sostenible   </h2>

{{--VALIDACION--}}
 @if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR OBJETIVO DESARROLLO SOSTENIBLE--}}

<a href="{{route('objetivoDesarrolloSostenible.create')}}"class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"> Nuevo Objetivo Desarrollo Sostenible</a>
    {{--TABLA PARA LISTAR TODOS LOS OBJETIVO DESARROLLO SOSTENIBLE--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th style="border: 1px solid #ccc; padding: 8px">ID</th>
                <th style="border: 1px solid #ccc; padding: 8px">NUMERO</th>
                <th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
                <th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
                <th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

            </tr>

        </thead>
        <tbody> 
            @foreach($objetivoDesarrolloSostenible as $objetivoDesarrolloSostenible)
                <tr class="border-b" >
                    <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->numero}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->nombre}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->descripcion}}</td>
                    <td class="p-2 flex gap-2">

                    {{-- Enlace para Editar --}}
                    <a href="{{ route('objetivoDesarrolloSostenible.edit', $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>

                    {{-- Enlace para Eliminar --}}
                     <form method="POST" action="{{ route('objetivoDesarrolloSostenible.destroy', $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible) }}" onsubmit="return confirm('¿Está seguro de eliminar este Objetivo de Desarrollo Sostenible?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Eliminar</button>
                    </form>

                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">
<a href="{{ route('dashboard.admin') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
@endsection