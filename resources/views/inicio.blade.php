@extends('layouts.app')

@section('title','Inicio')

@section('content')

<h2 class="text-2x1 font-bold mb-4"> Bienvenido al modulo de Planificacion -SIPeIP>   </h2>

<p class="mb-4"> Seleccione la opcion del menu para comenzar: </p> 

<ul class="list-disc ml-6 text-blue-700">

<li><a href="{{route('entidad.index')}}">Entidad</a></li>

<li><a href="{{route('persona.index')}}">Persona</a></li>

<li><a href="{{route('plan.index')}}">Plan</a></li>

<li><a href="{{route('programa.index')}}">Programa</a></li>
<li><a href="{{route('proyecto.index')}}">Proyecto</a></li>
<li class="navbar2"><a> Objetivo </a>
            <ul class="navbar-menu2">
                <li><a href="{{ route('objetivoEstrategico.index') }}">Objetivo Estrategico</a></li>
                <li><a href="{{ route('objetivoDesarrolloSostenible.index') }}">Objetivo Desarrollo Sostenible</a></li>
                <li><a href="{{ route('objetivoPlanNacional.index') }}">Objetivo Plan Nacional de Desarrollo</a></li>
            </ul>
</li>
<li class="navbar3"><a> Meta </a>
            <ul class="navbar-menu3">
                <li><a href="{{ route('metaEstrategica.index') }}">Meta Estrategica</a></li>
                <li><a href="{{ route('metaPlanNacional.index') }}">Meta Plan Nacional</a></li>
            </ul>
</li>
<li><a href="{{route('inicador.index')}}">Indicador</a></li>
<li><a href="{{route('plan.index')}}">Auditoria</a></li>

@endsection