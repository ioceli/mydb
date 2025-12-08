@extends('layouts.master')
@section('title','Inicio')
@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Objetivo Estrategico   </h2>
{{--VALIDACION--}}
 @if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
    @if(isset($message))
    <div class="bg-yellow-100 text-yellow-700 p-4 rounded mb-4">
        {{ $message }}
    </div>
@endif
<a href="{{route('objetivoEstrategico.create')}}" class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"> Nuevo Objetivo Estrategico</a>
{{--TABLA PARA MOSTRAR LOS OBJETIVOS ESTRATEGICOS--}}
<div class="overflow-x-auto bg-white rounded shadow">
<table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
        <tr>
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Descripción</th>
            <th class="border border-gray-300 px-4 py-2">Alineación con ODS </th>
            <th class="border border-gray-300 px-4 py-2">Alineación con OPND </th>
            <th class="border border-gray-300 px-4 py-2">Fecha Registro</th>
            <th class="border border-gray-300 px-4 py-2">Estado</th>
            <th class="border border-gray-300 px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($objetivoEstrategico as $objetivo)
            <tr class="border-b">
                <td class="border border-gray-300 px-4 py-2">{{ $objetivo->idObjetivoEstrategico }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $objetivo->descripcion }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    @if($objetivo->ods && $objetivo->ods->count())
                        <ul class="list-disc list-inside">
                            @foreach($objetivo->ods as $ods)
                                <li>{{ $ods->nombre }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-gray-500">Sin ODS asociados</span>
                    @endif
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    @if($objetivo->opnd && $objetivo->opnd->count())
                        <ul class="list-disc list-inside">
                            @foreach($objetivo->opnd as $opnd)
                                <li>{{ $opnd->descripcion }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-gray-500">Sin OPND asociados</span>
                    @endif
                </td>
                <td style="border: 1px solid #ccc; padding: 8px">{{ $objetivo->fechaRegistro }}</td>
                <td style="border: 1px solid #ccc; padding: 8px">{{ $objetivo->estado }}</td>
                    <td class="p-2 flex gap-2">
                    <a href="{{ route('objetivoEstrategico.edit', $objetivo->idObjetivoEstrategico) }}" 
                    class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm" title="Editar objetivo estratégico">
                        <i class="fas fa-edit mr-1"></i>
                        Editar
                    </a>
                           {{-- Enlace para Eliminar --}}
                    <form method="POST" action="{{ route('objetivoEstrategico.destroy', $objetivo->idObjetivoEstrategico) }}" 
                    class="inline"   
                    onsubmit="return confirmDelete(event, '{{ addslashes($objetivo->descripcion) }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm" title="Eliminar objetivo estratégico">
                            <i class="fas fa-trash-alt mr-1"></i>
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-gray-600">No hay objetivos estratégicos registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="mt-4">
<a href="{{ route('dashboard.tecnico') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- JavaScript para confirmación de eliminación --}}
<script>
    function confirmDelete(event, descripcion) {
        event.preventDefault();
        const form = event.target;
        Swal.fire({
            title: '¿Está seguro?',
            html: `Esta acción eliminará permanentemente el objetivo estratégico:<br><strong>"${descripcion}"</strong><br>y no podrá revertirse`,
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