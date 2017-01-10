<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Auth;
use Hash;
use App\Comments;
class UserController extends Controller{
	
	public function __construct(){
		$this->middleware('auth');
	}
	
	public function user(){
		return View('user.user');
	}

	public function profile(){
        return View('user.profile');
    }

    public function updateProfile(Request $request){
    	$rules = ['image' => 'required|image|max:1024*1024*1',];
        $messages = [
            'image.required' => 'La imagen es requerida',
            'image.image' => 'Formato no permitido',
            'image.max' => 'El máximo permitido es 1 MB',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return redirect('user/profile')->withErrors($validator);
        }
        else{
            $name = str_random(30) . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move('perfiles', $name);
            $user = new User;
            $user->where('email', '=', Auth::user()->email)
                 ->update(['perfiles' => 'perfiles/'.$name]);
            return redirect('user')->with('status', 'Su imagen de perfil ha sido cambiada con éxito');
        }
    }

    public function password(){
        return View('user.password');
    }

    public function updatePassword(Request $request){
        $rules = [
            'mypassword' => 'required',
            'password' => 'required|confirmed|min:6|max:18',
        ];
        
        $messages = [
            'mypassword.required' => 'El campo es requerido',
            'password.required' => 'El campo es requerido',
            'password.confirmed' => 'Los passwords no coinciden',
            'password.min' => 'El mínimo permitido son 6 caracteres',
            'password.max' => 'El máximo permitido son 18 caracteres',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect('user/password')->withErrors($validator);
        }
        else{
            if (Hash::check($request->mypassword, Auth::user()->password)){
                $user = new User;
                $user->where('email', '=', Auth::user()->email)
                     ->update(['password' => bcrypt($request->password)]);
                return redirect('user')->with('status', 'Password cambiado con éxito');
            }
            else
            {
                return redirect('user/password')->with('message', 'Credenciales incorrectas');
            }
        }
    }

    public function createComment(Request $request){
        $comment = e($request->comment);
        $date = date('Y-m-d');
        $time = date('H:m:s');
        Comments::insert([
            'comment' => $comment,
            'id_user' => Auth::user()->id,
            'date' => $date,
            'time' => $time,
        ]);
        return redirect()->back()->with('status', 'Enhorabuena comentario publicado con éxito');
    }

    public function deleteComment(Request $request){
        $rules = ['id_comment' => 'integer'];
        $validator = Validator::make($request->only('id_comment'), $rules);
        if ($validator->fails()){
            return redirect()->back()->with('error', 'Ha ocurrido un error');
        }
        else
        {
            if(Comments::where('id', '=', $request->id_comment)
                    ->where('id_user', '=', Auth::user()->id)->delete()
                    ){
                return redirect()->back()->with('status', 'Enhorabuena comentario eliminado con éxito');
            }
            else{
                return redirect()->back()->with('error', 'Ha ocurrido un error');  
            }
        }
    }

    public function editComment(Request $request){
        $rules = ['id_comment' => 'integer'];
        $comment = e($request->comment);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return redirect()->back()->with('error', 'Ha ocurrido un error');
        } else{
            if (Comments::where('id', '=', $request->id_comment)
                    ->where('id_user', '=', Auth::user()->id)
                    ->update(['comment' => $comment])){
                return redirect()->back()->with('status', 'Enhorabuena comentario editado correctamente');
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error');
            }
        }
    }

    protected function downloadFile($src){
        if(is_file($src)){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $content_type = finfo_file($finfo, $src);
            finfo_close($finfo);
            $file_name = basename($src).PHP_EOL;
            $size = filesize($src);
            header("Content-Type: $content_type");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: $size");
            readfile($src);
            return true;
        } else{
            return false;
        }
    }

     public function download(){
        if(!$this->downloadFile(app_path()."/files/terminos.pdf")){
            return redirect()->back();
        }
    }

	
}