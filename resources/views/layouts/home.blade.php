<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE-edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=!"/>
	<title>@yield('title')</title>
	<meta name="description" content="@yield('description')"/>
	<meta name="keywords" content="@yield('keywords')"/>
	<link rel="stylesheet" type="text/css" href="{{url()}}/bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="{{url()}}/bootstrap/js/jquery.js"></script>
	<script type="text/javascript" src="{{url()}}/bootstrap/js/bootstrap.min.js">
	</script>
	</head>
	<body>

		<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{url()}}">Tutorial Laravel</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="{{url()}}">Inicio</a></li>
          </ul>

          
<form class="navbar-form navbar-left" role="search" action="{{url('home/searchredirect')}}">
 <div class="form-group">
  <input type="text" class="form-control" name='search' placeholder="Buscar ..." value='@yield("search")' />
 </div>
 <button type="submit" class="btn btn-default">Buscar</button>
</form>

          <ul class="nav navbar-nav navbar-right">
   @if (Auth::check())
                        @if (Auth::user()->user == 1)
   <li><a href="{{url('admin')}}">Panel de Administrador</a></li>
                        @endif
   <li><a href="{{url('user')}}">{{Auth::user()->name}}</a></li>
   <li><a href="{{url('auth/logout')}}">Salir</a></li>
   @else
            <li><a href="{{url('auth/login')}}">Iniciar sesión</a></li>
   @endif
          </ul>
        </div>
      </div>
    </nav>

		<div class="container" style="margin-top: 50px;">
			@yield('content')
		</div>
	</body>
</html>