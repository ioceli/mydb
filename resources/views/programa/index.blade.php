@extends('layouts.master')
@section('title','Inicio')
@section('content')
@php
    use App\Enums\EstadoRevisionEnum;
    use App\Enums\EstadoAutoridadEnum;
@endphp 
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-externo-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
<h2 class="text-2x1 font-bold mb-4"> Listado de programa   </h2>
{{--VALIDACION--}}
    @if (session ('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{session('success')}}
        </div>
    @endif
        @if(isset($message))
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded mb-4">
            {{ $message }}
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
                <th class="border: 1px solid #ccc; padding: 8px">ALINEACION CON OBJETIVO ESTRATEGICO</th>
                <th style="border: 1px solid #ccc; padding: 8px">ALINEACION CON META ESTRATEGICA</th>
                <th style="border: 1px solid #ccc; padding: 8px">ESTADO POR TECNICO</th>
                <th style="border: 1px solid #ccc; padding: 8px">ESTADO POR AUTORIDAD</th>
                <th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
            @forelse($programa as $index => $p)
                <tr class="border-b">
                    <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{$p->entidad->subSector}}</td>
                    <td class="border p-2">{{ $p->cup }}: {{ $p->nombre }}</td>
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
                    <td class="border p-2">
                        @if ($p->metasEstrategicas->count())
                            <ul class="list-disc list-inside">
                                @foreach ($p->metasEstrategicas as $meta)
                                    <li>{{ $meta->descripcion }}</li>
                                @endforeach
                            </ul>
                            @else
                                <span class="text-gray-500">Sin metas</span>
                        @endif
                    </td>
                    <td class="border p-2">{{ $p->estado_revision }}</td>
                    <td class="border p-2">{{ $p->estado_autoridad }}</td>
                    <td class="p-2 flex gap-2">
                         {{-- Enlace para Editar --}}
                <a href="{{ route('programa.edit', $p->idPrograma) }}" 
                class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm" title="Editar programa">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                {{-- Formulario para Eliminar --}}
                <form action="{{ route('programa.destroy', $p->idPrograma) }}" method="POST" 
                class="inline" 
                onsubmit="return confirmDelete(event, '{{addslashes($p->nombre)}}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm" title="Eliminar programa">
                            <i class="fas fa-trash-alt mr-2"></i>
                                Eliminar
                            </button>
                        </form>
                       </td>
        </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-500">No hay programa registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
<a href="{{ route('dashboard.externo') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
        </div>
    </div>
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JavaScript para confirmación de eliminación --}}
    <script>
        function confirmDelete(event, nombre) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                title: '¿Está seguro?',
                html: `Esta acción eliminará permanentemente el programa:<br><strong>"${nombre}"</strong><br>y no podrá revertirse`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }
    </script>
    {{-- Íconos Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection