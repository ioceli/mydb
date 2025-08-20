<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPeIP')</title>
   <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fuente moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans text-gray-900">

    {{-- Encabezado institucional --}}
    <header class="bg-blue-900 text-white shadow">
        <div class="container mx-auto px-4 py-4 text-center">
            <h1 class="text-2xl font-bold">Sistema Integrado de Planificación e Inversión Pública - SIPeIP</h1>
        </div>
    </header>

    {{-- Barra de navegación --}}
<nav class="bg-blue-600 text-white border-b border-blue-800 px-4 py-2 shadow">
    <div class="container mx-auto flex items-center justify-between">
        <a href="{{ url('/') }}" class="text-xl font-semibold"></a>          
                {{-- Sesión del usuario --}}
                <div class="d-flex align-items-center">
                    @guest
                        <a class="btn btn-light text-2xl font-bold me-4" href="{{ route('login') }}">Iniciar sesión</a>
                        <a class="btn btn-light text-2xl font-bold" href="{{ route('register') }}">Registrarse</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Pie de página --}}
    <footer class="text-center mt-4 py-3 bg-gray-200">
        <small>&copy; {{ date('Y') }} Secretaría Nacional de Planificación. Todos los derechos reservados.</small>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>