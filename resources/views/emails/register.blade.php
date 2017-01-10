<h1>Bienvenid@ {{$data['name']}}</h1>
<a href="{{url()}}/auth/confirm/email/{{$data['email']}}/confirm_token/{{$data['confirm_token']}}">Confirmar mi cuenta</a>