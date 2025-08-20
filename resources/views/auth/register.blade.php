@extends('layouts.master')
@section('title', 'Register')
@section('content')
    @php
        use App\Enums\RolEnum;
        use App\Enums\EstadoEnum;
        use App\Enums\GeneroEnum;
    @endphp
<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">

        @csrf
<div>
   <label for="idEntidad" class="block text-sm font-medium text-gray-700 mb-1">ENTIDAD</label>

<select name="idEntidad" id="idEntidad" 
    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
    <option value="">Seleccione una entidad</option>
    @foreach ($entidad as $entidad)
        <option value="{{ $entidad->idEntidad }}">{{ $entidad->subSector }}</option>
    @endforeach
</select>
 </div>
        <!-- CEDULA -->
        <div>
            <x-input-label for="cedula" :value="__('Cedula')" />
            <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" required autofocus autocomplete="cedula" />
            <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
        </div>
        <!-- NOMBRES -->
        <div>
            <x-input-label for="name" :value="__('Nombres')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- APELLIDOS -->
        <div>
            <x-input-label for="apellidos" :value="__('Apellidos')" />
            <x-text-input id="apellidos" class="block mt-1 w-full" type="text" name="apellidos" :value="old('apellidos')" required autofocus autocomplete="apellidos" />
            <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
        </div>
        <div>
    <label class="block">ROL</label>
    <select name="rol" required>
        <option value="">Seleccione un rol</option>
        @foreach (RolEnum::cases() as $rol)
            <option value="{{ $rol->value }}" {{ old('rol') === $rol->value ? 'selected' : '' }}>
                {{ $rol->value }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label class="block">ESTADO</label>
     <select name="estado" required>
 <option value="">Seleccione un estado</option>
        @foreach (EstadoEnum::cases() as $estado)
            <option value="{{ $estado->value }}" {{ old('estado') === $estado->value ? 'selected' : '' }}>
                {{ $estado->value }}
            </option>
        @endforeach
    </select>
</div>
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
<div>
    <label class="block">GENERO</label>
    <select name="genero" required>
            <option value="">Seleccione un genero</option>
        @foreach (GeneroEnum::cases() as $genero)
            <option value="{{ $genero->value }}" {{ old('genero') === $genero->value ? 'selected' : '' }}>
                {{ $genero->value }}
            </option>
        @endforeach
    </select>
</div>
        <!-- TELEFONO -->
        <div>
            <x-input-label for="telefono" :value="__('Telefono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autofocus autocomplete="telefono" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Ya registrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection