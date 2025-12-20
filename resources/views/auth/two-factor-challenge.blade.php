@extends('layouts.master')
@section('title', 'Autenticación Multifactor')
@section('content')
<div class="flex flex-col items-center justify-center  p-2">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-6 sm:p-2">
        <!-- Encabezado -->
        <div class="text-center mb-2">
            <div class="mx-auto mb-2 flex items-center justify-center w-14 h-14 rounded-full bg-blue-100">
                <i class="bi bi-shield-lock text-blue-600 text-2xl"></i>
            </div>
            <h2 class="text-s font-bold text-gray-800">
                Verificación de Seguridad
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Ingrese el código de 6 dígitos enviado a su correo
            </p>
        </div>

        <!-- Error -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 text-sm p-3 mb-2 rounded-lg flex items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-2">
            @csrf

            <div class="flex justify-center">
                <label for="two_factor_code" class="block text-sm font-semibold text-gray-700 mb-1">
                    
                    </label>
<input
    type="text"
    id="two_factor_code"
    name="two_factor_code"
    inputmode="numeric"
    autocomplete="one-time-code"
    maxlength="6"
    placeholder="••••••"
    class="max-w-xs mx-auto text-center tracking-widest text-xs border border-gray-300 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block"
    required
    autofocus
>
            </div>

            <!-- Botón -->
             <div class="flex justify-center">
<button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition gap-2 text-sm">
    <i class="bi bi-check-circle"></i>
    Verificar código
</button>
            </div>
        </form>

        <!-- Ayuda -->
        <div class="text-center mt-6 text-sm text-gray-500">
            ¿Problemas para ingresar el código?<br>
            <span class="text-gray-400">
                Verifique la hora de su dispositivo o vuelva a iniciar sesión.
            </span>
        </div>

    </div>
</div>
@endsection
