@extends('layouts.master')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de programa   </h2>

{{--VALIDACION--}}
     @if (session ('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR PROGRAMA--}}

<a href="{{route('programa.create')}}" class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nuevo Programa</a>
    {{--TABLA PARA LISTAR TODOS LOS PROGRAMAS--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th style="border: 1px solid #ccc; padding: 8px">ID</th>
                <th style="border: 1px solid #ccc; padding: 8px">ENTIDAD</th>
                <th style="border: 1px solid #ccc; padding: 8px">NOMBRE DEL PROGRAMA</th>
                <th class="border: 1px solid #ccc; padding: 8px">OBJETIVO ESTRATEGICO</th>
                <th style="border: 1px solid #ccc; padding: 8px">ESTADO</th>
                <th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($programa as $index => $p)
                <tr class="border-b">
                    <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{$p->entidad->subSector}}</td>
                    <td class="border p-2">{{$p->nombre}}</td>
                    <td class="border p-2">
                     @if ($p->objetivosEstrategicos->count())
                    <ul class="list-disc list-inside">
                        @foreach ($p->objetivosEstrategicos as $objetivo)
                            <li>{{ $objetivo->descripcion }}</li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-gray-500">Sin objetivos</span>
                @endif
            </td>





                    <td style="border: 1px solid #ccc; padding: 8px">{{$p->estado}}</td>
                    <td class="p-2 flex gap-2">

                        {{-- Enlace para Editar --}}
                        <a href="{{ route('programa.edit', $p->idPrograma) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>

                        {{-- Enlace para Eliminar --}}
                        <form method="POST" action="{{ route('programa.destroy', $p->idPrograma) }}" onsubmit="return confirm('¿Está seguro de eliminar este programa?')">
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
<a href="{{ route('dashboard.externo') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
@endsection