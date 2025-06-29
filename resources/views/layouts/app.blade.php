<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPeIP - @yield('title')</title>

    <!-- Fuente moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- ESTILO PERSONALIZADO -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

</head>
<body>

    {{-- Header --}}
    <header>
        <h1>Sistema Integrado de Planificación e Inversión Pública - SIPeIP</h1>
    </header>

    {{-- Barra de navegación --}}
    <nav class="navbar">
    <ul class="navbar-menu">
        <li><a href="{{ url('/') }}">Inicio</a></li>
        <li>|</li>
        <li><a href="{{ route('entidad.index') }}">Entidad</a></li>
        <li>|</li>
        <li><a href="{{ route('persona.index') }}">Persona</a></li>
        <li>|</li>
        <li><a href="{{ route('plan.index') }}">Plan</a></li>
        <li>|</li>
        <li><a href="{{ route('programa.index') }}">Programa</a></li>
        <li>|</li>
        <li><a href="{{ route('proyecto.index') }}">Proyecto</a></li>
        <li>|</li>
        <li class="navbar1"><a> Objetivo </a>
            <ul class="navbar-menu1">
                <li><a href="{{ route('persona.index') }}">Objetivo Estrategico</a></li>
                <li><a href="{{ route('persona.index') }}">Objetivo Desarrollo Sostenible</a></li>
                <li><a href="{{ route('persona.index') }}">Objetivo Plan Nacional de Desarrollo</a></li>
            </ul>
        </li>
        <li>|</li>
        <li><a href="{{ route('persona.index') }}">Meta</a></li>
        <li>|</li>
        <li><a href="{{ route('persona.index') }}">Indicador</a></li>
        <li>|</li>
        <li><a href="{{ route('persona.index') }}">Auditoria</a></li>
    </ul>
</nav>

    {{-- Contenido principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Pie de página --}}
    <footer>
        <small>&copy; {{ date('Y') }} Secretaría Nacional de Planificación. Todos los derechos reservados.</small>
    </footer>

</body>
</html>