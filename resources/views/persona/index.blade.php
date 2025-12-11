@extends('layouts.master')
@section('title', 'Gestión de Usuarios')
@section('content')
<div class="container mx-auto p-4">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Administración')</title>
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .pagination li {
            margin: 0 2px;
        }
        .pagination li a,
        .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            transition: all 0.15s ease;
        }
        .pagination li a:hover {
            background-color: #f3f4f6;
            color: #374151;
            border-color: #d1d5db;
        }
        .pagination li.active span {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        {{-- Menú Lateral --}}
         <x-admin-sidebar />
        {{-- Contenido principal --}}
        <div class="flex-1 overflow-y-auto">
            <div class="container mx-auto p-6">
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-800 border-b pb-2">Gestión de Usuarios del Sistema</h1>
                    <p class="text-gray-500 mt-2">Administra todos los usuarios del sistema desde este panel</p>
                </div>
                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p class="font-bold">¡Éxito!</p>
                        </div>
                        <p class="mt-1">{{ session('success') }}</p>
                    </div>
                @endif
                {{-- Acción Principal y Estadísticas --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <a href="{{ route('persona.create') }}" 
                           class="inline-flex items-center px-4 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>
                            Nuevo Usuario
                        </a>
                    </div>
                    @if(request()->hasAny(['estado', 'rol', 'entidad']))
                    <div class="mt-4 md:mt-0">
                        <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-200">
                            <p class="text-sm text-gray-600">Total de usuarios: <span class="font-bold text-blue-700">{{ $usuarios->total() }}</span></p>
                        </div>
                    </div>
                    @endif
                </div>
                {{-- FORMULARIO DE FILTROS --}}
                <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-blue-200">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                        <i class="fas fa-filter mr-2 text-blue-600"></i>
                        Filtros de Búsqueda
                    </h2>
                    <form method="GET" action="{{ route('persona.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        {{-- Filtro por Estado --}}
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado del Usuario</label>
                            <select id="estado" name="estado" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                                <option value="">Todos los Estados</option>
                                @foreach(['Activo', 'Inactivo'] as $estado)
                                    <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Filtro por Rol --}}
                        <div>
                            <label for="rol" class="block text-sm font-medium text-gray-700 mb-1">Rol del Usuario</label>
                            <select id="rol" name="rol" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                                <option value="">Todos los Roles</option>
                                @foreach(['Administrador del Sistema', 'Técnico de Planificación', 'Revisor Institucional', 'Autoridad Validante', 'Usuario Externo', 'Auditor' ] as $rol)
                                    <option value="{{ $rol }}" {{ request('rol') == $rol ? 'selected' : '' }}>
                                        {{ ucfirst($rol) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Registros por página --}}
                        <div>
                            <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Registros por página</label>
                            <select id="per_page" name="per_page" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                                @foreach([10, 25, 50, 100] as $num)
                                    <option value="{{ $num }}" {{ request('per_page', 10) == $num ? 'selected' : '' }}>
                                        {{ $num }} registros
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex space-x-2">
                            <button type="submit" name="buscar" value="true"
                               class="w-full px-4 py-2 bg-blue-600 text-white rounded-md font-bold hover:bg-blue-700 transition duration-150 shadow-md">
                                <i class="fas fa-search mr-1"></i> Buscar
                            </button>
                            <a href="{{ route('persona.index') }}"
                                 class="w-full px-4 py-2 bg-gray-300 text-gray-800 rounded-md font-bold hover:bg-gray-400 transition duration-150 text-center shadow-md">
                                <i class="fas fa-eraser mr-1"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>
                {{-- TABLA - SOLO SE MUESTRA SI SE APLICARON FILTROS --}}
                @if(request()->has('buscar') || request()->hasAny(['estado', 'rol', 'entidad']))
                <div class="mb-10 p-4 border rounded-xl shadow-lg bg-gray-50">
                    <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-gray-100">
                        <h2 class="text-xl font-bold text-gray-800">Resultados de la Búsqueda</h2>
                        <p class="text-sm text-gray-600 mt-1">{{ $usuarios->total() }} usuarios encontrados</p>
                        {{-- Mostrar filtros activos --}}
                        @if(request()->hasAny(['estado', 'rol', 'entidad']))
                        <div class="mt-2 flex flex-wrap gap-2">
                            @if(request('estado'))
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full flex items-center">
                                <i class="fas fa-filter mr-1 text-xs"></i> Estado: {{ request('estado') }}
                            </span>
                            @endif
                            @if(request('rol'))
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full flex items-center">
                                <i class="fas fa-filter mr-1 text-xs"></i> Rol: {{ ucfirst(request('rol')) }}
                            </span>
                            @endif
                        </div>
                        @endif
                    </div>
                    @if($usuarios->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border">
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">ENTIDAD</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">CÉDULA</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">NOMBRES</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">APELLIDOS</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">ROL</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">ESTADO</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">CORREO</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">GÉNERO</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">TELÉFONO</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($usuarios as $usuario)
                                <tr class="border-b hover:bg-blue-50 transition duration-100">
                                    <td class="border p-3">
                                        <span class="text-sm font-semibold text-gray-900">{{ $usuario->idUser }}</span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="text-sm text-gray-700">{{ $usuario->entidad->subSector ?? 'Sin entidad' }}</span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="text-sm font-mono text-gray-900">{{ $usuario->cedula }}</span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="text-sm font-medium text-gray-900">{{ $usuario->name }}</span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="text-sm text-gray-900">{{ $usuario->apellidos }}</span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full 
                                            {{ $usuario->rol == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                               ($usuario->rol == 'revisor' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($usuario->rol) }}
                                        </span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full 
                                            {{ $usuario->estado == 'Activo' ? 'bg-green-100 text-green-800' : 
                                               ($usuario->estado == 'Inactivo' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $usuario->estado }}
                                        </span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="text-sm text-gray-600 truncate max-w-xs block">{{ $usuario->email }}</span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="text-sm text-gray-700">{{ $usuario->genero ?? 'N/A' }}</span>
                                    </td>
                                    <td class="border p-3">
                                        <span class="text-sm text-gray-700">{{ $usuario->telefono ?? 'N/A' }}</span>
                                    </td>
                                    <td class="border p-3 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('persona.edit', $usuario->idUser) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm"
                                               title="Editar usuario">
                                                <i class="fas fa-edit mr-1"></i>
                                                Editar
                                            </a>
                                            <form method="POST" action="{{ route('persona.destroy', $usuario->idUser) }}" 
                                                  class="inline"
                                                  onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm"
                                                        title="Eliminar usuario">
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
                    {{-- Paginación --}}
                    @if($usuarios->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div class="mb-4 md:mb-0">
                                <p class="text-sm text-gray-700">
                                    Mostrando 
                                    <span class="font-semibold">{{ $usuarios->firstItem() ?? 0 }}</span> 
                                    a 
                                    <span class="font-semibold">{{ $usuarios->lastItem() ?? 0 }}</span> 
                                    de 
                                    <span class="font-semibold">{{ $usuarios->total() }}</span> 
                                    usuarios
                                </p>
                            </div>
                            <div class="flex justify-center">
                                {{ $usuarios->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    @else
                    {{-- Mensaje cuando no hay resultados --}}
                    <div class="p-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-700">No se encontraron usuarios</h3>
                            <p class="text-gray-500 mt-2">No hay usuarios que coincidan con los filtros aplicados.</p>
                            <a href="{{ route('persona.index') }}" class="mt-4 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-medium hover:bg-blue-200 transition">
                                <i class="fas fa-eraser mr-1"></i> Limpiar filtros
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                @else
                {{-- Mensaje inicial cuando no hay filtros aplicados --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg shadow-md mt-8" role="alert">
                    <h3 class="font-bold text-lg mb-2 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Instrucciones
                    </h3>
                    <p class="mb-4">Para ver los usuarios, selecciona al menos un filtro y haz clic en <strong class="text-blue-800">Buscar</strong>.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('persona.index') }}?estado=Activo&buscar=true" 
                           class="px-3 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition flex items-center">
                            <i class="fas fa-check-circle mr-2"></i> Ver usuarios activos
                        </a>
                        <a href="{{ route('persona.index') }}?rol=admin&buscar=true" 
                           class="px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition flex items-center">
                            <i class="fas fa-user-shield mr-2"></i> Ver administradores
                        </a>
                        <a href="{{ route('persona.index') }}?buscar=true&per_page=10" 
                           class="px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition flex items-center">
                            <i class="fas fa-users mr-2"></i> Ver todos los usuarios
                        </a>
                    </div>
                </div>
                @endif
                {{-- MENU PRINCIPAL --}}
                <div class="mt-8 pt-4 border-t">
                    <a href="{{ route('dashboard.admin') }}" 
                       class="inline-flex items-center px-4 py-3 bg-gray-700 text-white font-bold rounded-lg hover:bg-gray-800 transition duration-150 shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i>
                        PANEL ADMINISTRATIVO
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- JavaScript para confirmación de eliminación --}}
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción eliminará permanentemente el usuario y no podrá revertirse",
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
</body>
@endsection