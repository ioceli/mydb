@extends('layouts.master')

@section('title','Panel del Auditor')

@section('content')
<div class="flex">
    {{-- Menú lateral --}}
    <aside class="w-64 bg-blue-100 h-auto p-4 shadow-md">
        <h3 class="text-lg font-bold mb-4">Menú Auditor</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard.auditor') }}" class="block p-2 rounded hover:bg-gray-200">
                    Volver al Panel
                </a>
            </li>
            <li>
                <a href="{{ route('auditoria.index') }}" class="block p-2 rounded hover:bg-gray-200">
                    Actualizar Vista
                </a>
            </li>
        </ul>
    </aside>
    {{-- Contenido principal --}}
    <div class="flex-1 p-6">
        {{-- Validación --}}
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Título --}}
        <h2 class="text-2xl font-bold mb-4 text-center">Bitácora del Auditor</h2>

        {{-- Tabla de bitácora --}}
        @if ($bitacoras->isEmpty())
            <div class="bg-blue-100 text-blue-800 p-3 rounded">
                No hay registros disponibles en la bitácora.
            </div>
            @else
            <div class="d-flex justify-content-end mb-3">
                <form method="GET" action="{{ route('auditoria.index') }}" class="row g-2 align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Selecciona cuántos registros ver por página">
                    <div class="col-auto">
                        <label for="per_page" class="col-form-label">
                            <i class="bi bi-list-ul me-1"></i> Mostrar:
                        </label>
                    </div>
                    <div class="col-auto">
                        <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                </form>
            </div>
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
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                            new bootstrap.Tooltip(tooltipTriggerEl)
                            })
                            });
                        </script>
                </tbody>
            </table>
            <div class="mt-4">
                <a href="{{ route('auditoria.pdf', ['per_page' => $perPage]) }}" class="btn btn-danger mb-3">
                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                </a>
            </div>
            <div class="mt-4">
                {{ $bitacoras->appends(['per_page' => $perPage])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection