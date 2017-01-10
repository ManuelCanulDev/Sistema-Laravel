<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MiFormulario;
use Validator;
use App\Comments;
use App\User;

class HomeController extends Controller{
	public function home(){
		return View('home.home');
	}

	public function getId($id1,$id2){
		return "<h1>id1 es igual a " .$id1. "</h1> <h2>id2 es igual a " .$id2. "</h2>";
	}
	public function showView(){
		$msg = "Aprendiendo laravel 5";
		$array = [1,2,3,4,5,6,7,8,9];
		return View('home.showView',['msg' => $msg, 'array' => $array]);
	}

	public function form(Request $request){
		if($request->isMethod("post") && $request->has("name")){
			$name = $request->input("name");
		}
		else{
			$name ="";
		}
		return View("home.form", ["name" => $name]);
	}


	public function miFormulario(){
		return View("home.miformulario");
	}
	public function validarmiFormulario(MiFormulario $formulario){
			$validator = Validator::make(
			$formulario->all(),
			$formulario->rules(),
			$formulario->messages()
			);

	if($validator->valid()){

		if($formulario->ajax()){
			return response()->json(["valid" => true],200);
		}
		else{
			return redirect('home/miformulario')
		 	   ->with('message','Enhorabuena el formulario ha sido  enviado correctamente');
		}
	}
	}

	public function search($search){
        $search = urldecode($search);
       $comments = Comments::select()
  ->where('comment', 'LIKE', '%'.$search.'%')
  ->orderBy('id', 'desc')
  ->paginate(3);
        
        if (count($comments) == 0){
            return View('home.search')
            ->with('message', 'No hay resultados que mostrar')
            ->with('search', $search);
        } else{
            return View('home.search')
            ->with('comments', $comments)
            ->with('search', $search);
        }
    }

    public function user($id){
        $user = User::select()
                ->where('id', '=', $id)
                ->first();
        if (count($user) == 0){
            return redirect()->back();
        }
        else{
            return View('home.user')->with('user', $user);
        }
    }
}