@extends('layouts.home')
@section('content')
<h1>Bienvenid@ {{Auth::user()->name}} a su Panel de Control</h1>
@if (Session::has('status'))
<hr />
<div class='text-success'>
    {{Session::get('status')}}
</div>
<hr />
@endif

<img src='{{url(Auth::user()->perfiles)}}' class='img-responsive' style='max-width: 150px' />

<h3>Opciones:</h3>
<ul>
	<li><a href="{{url('home/user/'.Auth::user()->id)}}">Ir a mi perfil público</a></li>
    <li><a href="{{url('user/profile')}}">Cambiar mi imagen de perfil</a></li>
    <li><a href="{{url('user/password')}}">Cambiar mi password</a></li>
    <li><a href="{{url('user/download')}}">Descargar términos y condiciones de uso</a></li>
</ul>

@stop