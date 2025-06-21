<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitema Integrado de Planificación e Inversión Pública SIPeIP - @yield('title')</title>
{{-- Escribir Estilos --}}
<style>

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