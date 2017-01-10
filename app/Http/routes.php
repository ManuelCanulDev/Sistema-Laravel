<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/','HomeController@home');
Route::get('/home','HomeController@home');

Route::get('home/searchredirect', function(){
     
    /* Nuevo: si el argumento search está vacío regresar a la página anterior */
    if (empty(Input::get('search'))) return redirect()->back();
    
    $search = urlencode(e(Input::get('search')));
    $route = "home/search/$search";
    return redirect($route);
});
Route::get("home/search/{search}", "HomeController@search");

Route::get('home/id1/{id1}/id2/{id2}','HomeController@getId');

Route::get('home/showView','HomeController@showView');

//Peticiones del tipo get y del tipo Post
//Route::match(["get","post"], "home/form", "HomeController@form");
Route::any("home/form", "HomeController@form");

Route::get("home/nombre/{nombre}/apellidos/{apellidos}", function($nombre, $apellidos){
	return $nombre . " " . $apellidos;
	//VALIDAMOS CARACTERES DE RUTAS
})->where(["nombre" => "[a-zA-Z]+","apellidos" => "[a-zA-Záéíóú]+"]); 

Route::get("home/miformulario","HomeController@miFormulario");

Route::post("home/validarmiFormulario","HomeController@validarMiFormulario");

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/confirm/email/{email}/confirm_token/{confirm_token}', 'Auth\AuthController@confirmRegister');

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('user', 'userController@user');

Route::get('user/profile', 'UserController@profile');
Route::post('user/updateprofile', 'UserController@updateProfile');


Route::get('user/password', 'UserController@password');
Route::post('user/updatepassword', 'UserController@updatePassword');

Route::post('user/createcomment', 'UserController@createComment');
Route::post('user/createcomment', 'UserController@createComment');

Route::post('user/deletecomment', 'UserController@deleteComment');

Route::post('user/editcomment', 'UserController@editComment');

Route::get("home/user/{id}", "HomeController@user")->where(['id' => '[0-9]+']);

Route::get('user/download', 'UserController@download');

//Route::match(['get', 'post'], 'admin/createadmin', 'AdminController@createAdmin');

Route::get('admin', 'AdminController@admin');