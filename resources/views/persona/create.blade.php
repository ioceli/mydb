@extends('layouts.master')
@section('title', 'Nueva Persona')
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
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 border-b pb-2">Registrar Nuevo Usuario</h1>
            <p class="text-gray-500 mt-2">Complete el formulario para registrar un nuevo usuario en el sistema</p>
        </div>

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg border border-gray-200">
            <form method="POST" action="{{ route('persona.store') }}">
                @csrf
                
                {{-- Mensajes de error --}}
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <strong class="font-bold">¡Error!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Columna 1 --}}
                    <div class="space-y-4">
                        {{-- Entidad --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Entidad *</label>
                            <select name="idEntidad" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                <option value="">Seleccione una entidad</option>
                                @foreach ($entidades as $entidad)
                                    <option value="{{ $entidad->idEntidad }}" {{ old('idEntidad') == $entidad->idEntidad ? 'selected' : '' }}>
                                        {{ $entidad->subSector }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Cédula --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cédula *</label>
                            <input type="text" name="cedula" value="{{ old('cedula') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
                                   placeholder="Ej: 1234567890" required>
                        </div>

                        {{-- Nombres --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombres *</label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
                                   placeholder="Ej: Juan Carlos" required>
                        </div>

                        {{-- Apellidos --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
                                   placeholder="Ej: Pérez Gómez" required>
                        </div>

                        {{-- Correo Electrónico --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico *</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
                                   placeholder="Ej: usuario@dominio.com" required>
                        </div>
                    </div>

                    {{-- Columna 2 --}}
                    <div class="space-y-4">
                        {{-- Teléfono --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                            <input type="tel" name="telefono" value="{{ old('telefono') }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
                                   placeholder="Ej: 0991234567" required>
                        </div>

                        {{-- Género --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Género *</label>
                            <select name="genero" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                @foreach (GeneroEnum::values() as $genero)
                                    <option value="{{ $genero }}" {{ old('genero') == $genero ? 'selected' : '' }}>
                                        {{ $genero }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Rol --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rol *</label>
                            <select name="rol" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                @foreach (RolEnum::values() as $rol)
                                    <option value="{{ $rol }}" {{ old('rol') == $rol ? 'selected' : '' }}>
                                        {{ $rol }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                            <select name="estado" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                @foreach (EstadoEnum::values() as $estado)
                                    <option value="{{ $estado }}" {{ old('estado') == $estado ? 'selected' : 'selected' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Contraseña --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña *</label>
                            <input type="password" name="password" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
                                   placeholder="Mínimo 8 caracteres" required>
                        </div>

                        {{-- Confirmar Contraseña --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña *</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
                                   placeholder="Repita la contraseña" required>
                        </div>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                    <a href="{{ route('persona.index') }}" 
                       class="px-6 py-3 bg-gray-500 text-white font-bold rounded-lg hover:bg-gray-600 transition duration-150 shadow-md flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        VOLVER
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-150 shadow-md flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        GUARDAR USUARIO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Scripts adicionales si los necesitas --}}
@push('styles')
<style>
    /* Estilos específicos para el formulario si es necesario */
    input:focus, select:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
</style>
@endpush