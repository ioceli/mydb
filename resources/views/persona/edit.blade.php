@extends('layouts.master')
@section('title', 'Editar Usuario')
@section('content')

@php
    use App\Enums\RolEnum;
    use App\Enums\EstadoEnum;
    use App\Enums\GeneroEnum;
@endphp

{{-- ESTRUCTURA CON SIDEBAR --}}
<div class="flex min-h-screen">
    {{-- SIDEBAR IZQUIERDO --}}
    <x-admin-sidebar />
    
    {{-- CONTENIDO PRINCIPAL --}}
    <div class="flex-1 p-6">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 border-b pb-2">Editar Usuario</h1>
            <p class="text-gray-500 mt-2">Actualice la información del usuario: <span class="font-semibold text-blue-600">{{ $usuario->name }} {{ $usuario->apellidos }}</span></p>
        </div>

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong class="font-bold">¡Por favor corrige los siguientes errores!</strong>
                </div>
                <ul class="mt-2 ml-5 list-disc">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong class="font-bold">¡Éxito!</strong>
                </div>
                <p class="mt-1">{{ session('success') }}</p>
            </div>
        @endif

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-blue-100">
            <form action="{{ route('persona.update', $usuario->idUser) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Información del usuario actual --}}
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="font-semibold text-blue-800 mb-2">Información actual del usuario</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div><span class="font-medium">ID:</span> {{ $usuario->idUser }}</div>
                        <div><span class="font-medium">Cédula:</span> {{ $usuario->cedula }}</div>
                        <div><span class="font-medium">Estado:</span> 
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $usuario->estado == 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $usuario->estado }}
                            </span>
                        </div>
                        <div><span class="font-medium">Rol:</span> 
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                {{ $usuario->rol }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Campos del formulario en dos columnas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Columna izquierda --}}
                    <div class="space-y-4">
                        {{-- Entidad --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Entidad *</label>
                            <select name="idEntidad" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-gray-50" required>
                                <option value="">Seleccione una entidad</option>
                                @foreach ($entidades as $entidad)
                                    <option value="{{ $entidad->idEntidad }}" 
                                        {{ old('idEntidad', $usuario->idEntidad) == $entidad->idEntidad ? 'selected' : '' }}>
                                        {{ $entidad->subSector }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Cédula --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cédula *</label>
                            <input type="text" name="cedula" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" 
                                   placeholder="Número de cédula" 
                                   value="{{ old('cedula', $usuario->cedula) }}" 
                                   required>
                        </div>

                        {{-- Nombres --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                            <input type="text" name="name" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" 
                                   placeholder="Nombres completos" 
                                   value="{{ old('name', $usuario->name) }}" 
                                   required>
                        </div>

                        {{-- Apellidos --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                            <input type="text" name="apellidos" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" 
                                   placeholder="Apellidos completos" 
                                   value="{{ old('apellidos', $usuario->apellidos) }}" 
                                   required>
                        </div>
                    </div>

                    {{-- Columna derecha --}}
                    <div class="space-y-4">
                        {{-- Correo --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                            <input type="email" name="email" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" 
                                   placeholder="correo@ejemplo.com" 
                                   value="{{ old('email', $usuario->email) }}" 
                                   required>
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input type="tel" name="telefono" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" 
                                   placeholder="0991234567" 
                                   value="{{ old('telefono', $usuario->telefono) }}" 
                                   required>
                        </div>

                        {{-- Género --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Género *</label>
                            <select name="genero" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-gray-50" required>
                                @foreach (GeneroEnum::values() as $genero)
                                    <option value="{{ $genero }}" 
                                        {{ old('genero', $usuario->genero) == $genero ? 'selected' : '' }}>
                                        {{ $genero }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Rol --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                            <select name="rol" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-gray-50" required>
                                @foreach (RolEnum::values() as $rol)
                                    <option value="{{ $rol }}" 
                                        {{ old('rol', $usuario->rol) == $rol ? 'selected' : '' }}>
                                        {{ $rol }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                            <select name="estado" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-gray-50" required>
                                @foreach (EstadoEnum::values() as $estado)
                                    <option value="{{ $estado }}" 
                                        {{ old('estado', $usuario->estado) == $estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Campo de contraseña (opcional) --}}
                <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <h3 class="font-semibold text-yellow-800 mb-3">Cambiar Contraseña (Opcional)</h3>
                    <p class="text-sm text-yellow-600 mb-3">Deje estos campos en blanco si no desea cambiar la contraseña.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                            <input type="password" name="password" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" 
                                   placeholder="Mínimo 8 caracteres">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" 
                                   placeholder="Repita la nueva contraseña">
                        </div>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center">
                    <div class="mb-4 sm:mb-0">
                        <a href="{{ route('persona.index') }}" 
                           class="inline-flex items-center px-4 py-3 bg-gray-600 text-white font-bold rounded-lg hover:bg-gray-700 transition duration-150 shadow-md">
                            <i class="fas fa-arrow-left mr-2"></i>
                            VOLVER
                        </a>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-150 shadow-md">
                            <i class="fas fa-save mr-2"></i>
                            ACTUALIZAR USUARIO
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts adicionales --}}
@push('scripts')
<script>
    // Confirmación antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de actualizar la información del usuario?')) {
            e.preventDefault();
        }
    });
</script>
@endpush

@endsection