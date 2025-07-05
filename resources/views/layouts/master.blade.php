<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPeIP')</title>

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
            <h1 class="text-2xl font-bold">
                Sistema Integrado de Planificación e Inversión Pública - <span class="text-blue-200">SIPeIP</span>
            </h1>
        </div>
    </header>

    {{-- Barra de navegación --}}
    <nav class="navbar navbar-expand-lg navbar-secondary bg-light border-bottom px-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Inicio</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('entidad.index') }}">Entidad</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('plan.index') }}">Plan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('programa.index') }}">Programa</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('proyecto.index') }}">Proyecto</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Objetivo</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('objetivoEstrategico.index') }}">Objetivo Estratégico</a></li>
                            <li><a class="dropdown-item" href="{{ route('objetivoDesarrolloSostenible.index') }}">Objetivo ODS</a></li>
                            <li><a class="dropdown-item" href="{{ route('objetivoPlanNacional.index') }}">Objetivo PND</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Meta</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('metaEstrategica.index') }}">Meta Estratégica</a></li>
                            <li><a class="dropdown-item" href="{{ route('metaPlanNacional.index') }}">Meta PND</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('indicador.index') }}">Indicador</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('auditoria.index') }}">Auditoría</a></li>
                </ul>

                {{-- Sesión del usuario --}}
                <div class="d-flex align-items-center">
                    @guest
                        <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Login</a>
                        <a class="btn btn-primary" href="{{ route('register') }}">Registrarse</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
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
    <footer class="text-center mt-4 py-3 bg-light">
        <small>&copy; {{ date('Y') }} Secretaría Nacional de Planificación. Todos los derechos reservados.</small>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>