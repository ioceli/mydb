@extends('layouts.master')
@section('title','Inicio')
@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-tecnico-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
<h2 class="text-2xl font-bold mb-4"> Listado de Meta Plan Nacional   </h2>
{{--VALIDACION--}}
    @if (session ('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(isset($message))
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded mb-4">
            {{ $message }}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR META PLAN NACIONAL--}}
<a href="{{route('metaPlanNacional.create')}}" class="bg-green-500 text-white rounded px-4 py-2">Nueva Meta Plan Nacional</a>
    {{--TABLA PARA LISTAR TODOS LOS META PLAN NACIONAL--}}
<div class="overflow-x-auto bg-white rounded shadow mt-4">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">NOMBRE</th>
                <th class="border border-gray-300 px-4 py-2">DESCRIPCION</th>
                <th class="border border-gray-300 px-4 py-2">PORCENTAJE ALINEACION</th>
                <th class="border border-gray-300 px-4 py-2">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
            @forelse($metaPlanNacional as $metaPlanNacional)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->idMetaPlanNacional}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->nombre}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->descripcion}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->porcentajeAlineacion}}</td>
                    <td class="p-2 flex gap-2">
                        {{-- Enlace para Editar --}}
                        <a href="{{ route('metaPlanNacional.edit', $metaPlanNacional->idMetaPlanNacional) }}" 
                        class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm" title="Editar meta del plan nacional">
                            <i class="fas fa-edit mr-1"></i>
                            Editar
                        </a>
                        {{-- Enlace para Eliminar --}}
                        <form method="POST" action="{{ route('metaPlanNacional.destroy', $metaPlanNacional->idMetaPlanNacional) }}" 
                        class="inline"
                        onsubmit="return confirmDelete(event, '{{ addslashes($metaPlanNacional->nombre) }}')">
                          @csrf
                          @method('DELETE')
                            <button 
                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm" title="Eliminar meta del plan nacional">
                                <i class="fas fa-trash-alt mr-1"></i>
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-600">No hay metas del plan nacional registradas.</td>
                    </tr>
            @endforelse
</tbody>
</table>
</div>
<div class="mt-4">
    <a href="{{ route('dashboard.tecnico') }}" class="font-bold bg-gray-500 text-white rounded px-4 py-2">REGRESAR</a>
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
                html: `Esta acción eliminará permanentemente la meta estratégica:<br><strong>"${nombre}"</strong><br>y no podrá revertirse`,
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