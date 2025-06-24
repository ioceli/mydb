@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Bienvenido al modulo de Planificacion -SIPeIP>   </h2>

<p class="mb-4"> Seleccione la opcion del menu para comenzar: </p> 

<ul class="list-disc ml-6 text-blue-700">

<li><a href="{{route('entidad.index')}}">Entidades</a></li>
@endsection