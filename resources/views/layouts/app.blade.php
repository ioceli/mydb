<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPeIP - @yield('title')</title>

    <!-- Fuente moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f9fafb;
            color: #333;
        }

        header {
            background-color: #003366;
            color: #fff;
            padding: 20px 40px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav {
            background-color: #0055a5;
            padding: 10px 40px;
            display: flex;
            gap: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s, border-bottom 0.3s;
            padding-bottom: 5px;
        }

        nav a:hover {
            color: #ffdd57;
            border-bottom: 2px solid #ffdd57;
        }

        main {
            padding: 30px 40px;
            background-color: #fff;
            min-height: 70vh;
        }

        footer {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 15px;
        }

        footer small {
            font-size: 14px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <header>
        <h1>Sistema Integrado de Planificación e Inversión Pública - SIPeIP</h1>
    </header>

    {{-- Barra de navegación --}}
    <nav>
        <a href="{{ url('/') }}">Inicio</a>
        <a href="{{ route('entidad.index') }}">Entidades</a>
        <a href="{{ route('persona.index') }}">Personas</a>
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