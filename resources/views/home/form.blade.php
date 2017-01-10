<h1>POST</h1>

<form method="post" action="{{url('home/form')}}">
	<label>Name:</label>
	<input type="text" name="name" value="{{$name}}"/>

	{{csrf_field()}}

	<button type="submit">Send</button>
</form>

Valor del campo anme: {{$name}}