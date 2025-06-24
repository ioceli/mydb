<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitema Integrado de Planificación e Inversión Pública SIPeIP - @yield('title')</title>
    {{-- Escribir Estilos --}}
<!-- <link rel="stylesheet" href="{{ asset('css/estilos.css') }}"> {{--ESTILOS PERSONALIZADOS--}}     

{{--FUENTE OPCIONAL--}} 
<link href="https://fonts.googleapis.com/css2?family=Robot&display=swap" rel="stylesheet"> -->
<style>
            body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        header, nav, footer {
            padding: 15px;
        }

        header {
            background-color: #003366;
            color: white;
        }

        nav {
            background-color: #0055a5;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #ddd;
            text-align: center;
        }
</style>
</head>
<body>

{{-- Header --}}

    <header>
<h1>Sitema Integrado de Planificación e Inversión Pública SIPeIP </h1>
</header>

{{-- Barra de navegacion --}}

<nav>

    <a href="{{url('/')}}">Inicio</a>
    <a href="{{route('entidad.index')}}"> Entidad</a>
</nav>
    
{{-- Contenido Principal--}}

<main>

@yield('content')

</main>

<footer>

<small>&copy;

</small>

</footer>

</body>
</html>