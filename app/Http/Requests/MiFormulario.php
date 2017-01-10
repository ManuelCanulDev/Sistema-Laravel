<?php 

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
* 
*/
class MiFormulario extends Request{
	protected $redirect = "home/miformulario";

	public function rules(){
		return [
		'nombre' => 'required|min:3|max:12|regex:/^[a-z]+$/i',
		'email' => 'required|email',
	];
	}

	public function messages(){
		return[
   'nombre.required' => 'El campo nombre es requerido',
   'nombre.min' => 'El minimo permitido son 3 caracteres',
   'nombre.max' => 'El maximo permitido son 12 caracteres',
   'nombre.regex' => 'Solo se aceptan letras',
   'email.required' => 'El campo email es requerido',
   'email.email' => 'El formato de email es incorrecto',
		];
	}

	public function response(array $errors){
		if ($this->ajax()) {
			return response()->json($errors, 200);
		}
		else{
		return redirect($this->redirect)
		->withErrors($errors,'formulario')
		->withInput();
        }
		
	}

	public function authorize(){
		return true;
	}
}