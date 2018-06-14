<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('principal', function () {
    return view('principal.contenido');
});

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('usuarios');

Route::resource('usuarios', 'UsuariosController');
Route::get('usuarios', 'UsuariosController@index');
Route::get('get_usuarios', 'UsuariosController@getUsuarios');
Route::get('get_datos_usuario','UsuariosController@get_datos_usuario');

Route::get('$',function(){ echo 0;});//url auxiliar

Route::group(['namespace' => 'permisos'], function() {
        Route::resource('modulos', 'ModulosController');
        Route::resource('sub_modulos', 'Sub_ModulosController');
        Route::resource('permisos', 'Permisos_Modulo_UsuarioController');
});

Route::group(['namespace' => 'eventos'], function() {
        Route::resource('eventos', 'EventosController');
        Route::get('getEventos', 'EventosController@getEventos');
        Route::get('createEvento', 'EventosController@createEvento');
        Route::get('updateFecha', 'EventosController@updateFecha');
        Route::get('deleteEvento', 'EventosController@deleteEvento');
});

Route::group(['namespace' => 'auditorios'], function() {
        Route::resource('auditorios', 'AuditoriosController');
        Route::get('getAuditorios', 'AuditoriosController@getAuditorios');
});

Route::group(['namespace' => 'materiales'], function() {
        Route::resource('materiales', 'MaterialesController');
        Route::get('getMateriales', 'MaterialesController@getMateriales');
        //Route::get('autocompletar_nombre_persona', 'MaterialesController@autocompletar_nombre_persona');
});

Route::group(['namespace' => 'recibos'], function() {
        Route::resource('recibos', 'RecibosController');
        Route::get('getRecibos', 'RecibosController@getRecibos');
});

Route::group(['namespace' => 'caja'], function() {
        Route::resource('caja', 'CajaController');
        Route::get('getRecibosEmititos', 'CajaController@getRecibosEmititos');
});