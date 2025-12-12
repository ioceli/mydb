@extends('layouts.master')

@section('title', 'Inicio')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-tecnico-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
            <h2 class="text-2xl font-bold mb-4">Listado de Objetivos Desarrollo Sostenible</h2>

            {{-- VALIDACION --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- BOTON PARA LLAMAR AL FORMULARIO CREAR OBJETIVO DESARROLLO SOSTENIBLE --}}
            <a href="{{ route('objetivoDesarrolloSostenible.create') }}" 
               class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-150">
                Nuevo Objetivo Desarrollo Sostenible
            </a>

            {{-- TABLA PARA LISTAR TODOS LOS OBJETIVOS DESARROLLO SOSTENIBLE --}}
            <div class="overflow-x-auto bg-white rounded shadow mt-4">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">NUMERO</th>
                            <th class="border border-gray-300 px-4 py-2">NOMBRE</th>
                            <th class="border border-gray-300 px-4 py-2">DESCRIPCION</th>
                            <th class="border border-gray-300 px-4 py-2">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($objetivos as $ods)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">{{ $ods->idObjetivoDesarrolloSostenible }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ods->numero }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ods->nombre }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ods->descripcion }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="flex gap-2">
                                        {{-- Enlace para Editar --}}
                                        <a href="{{ route('objetivoDesarrolloSostenible.edit', $ods->idObjetivoDesarrolloSostenible) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150"
                                           title="Editar objetivo de desarrollo sostenible">
                                            <i class="fas fa-edit mr-1"></i>
                                            Editar
                                        </a>

                                        {{-- Formulario para Eliminar --}}
                                        <form method="POST" 
                                              action="{{ route('objetivoDesarrolloSostenible.destroy', $ods->idObjetivoDesarrolloSostenible) }}" 
                                              class="inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($ods->nombre) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150"
                                                    title="Eliminar objetivo de desarrollo sostenible">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Botón para regresar --}}
            <div class="mt-6">
                <a href="{{ route('dashboard.tecnico') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">
                    REGRESAR
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Íconos Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- JavaScript para confirmación de eliminación --}}
<script>
    function confirmDelete(event, nombre) {
        event.preventDefault();
        const form = event.target;
        
        Swal.fire({
            title: '¿Está seguro?',
            html: `Esta acción eliminará permanentemente el objetivo:<br><strong>"${nombre}"</strong><br>y no podrá revertirse`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        
        return false;
    }
</script>
@endsection