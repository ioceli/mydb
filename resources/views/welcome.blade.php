<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Módulo de Planificación - SIPeIP</h1>

        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 underline">Entrar al sistema</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Iniciar Sesión</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</x-guest-layout>