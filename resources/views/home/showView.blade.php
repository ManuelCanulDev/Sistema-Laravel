@extends('layouts.home')
@section('title', 'Titulo del sitio web')
@section('description', 'Descripcion del sitio web')
@section('keywords', 'Palabras, clave, del, sitio, web')

@section('content')

<h1>Tutorial laravel 5</h1>
{{$msg}}

@foreach ($array as $index => $val)
	<p>{{$index}} = {{$val}}</p>
@endforeach

@stop