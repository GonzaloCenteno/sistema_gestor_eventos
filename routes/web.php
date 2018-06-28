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

Route::group(['namespace' => 'principal'], function() {
        Route::resource('principal', 'PrincipalController');
        Route::get('autocompletar_eventos', 'PrincipalController@autocompletar_eventos');
        Route::get('insertar_datos_recibo', 'PrincipalController@insertar_datos_recibo');
        Route::get('insertar_datos_inscripcion', 'PrincipalController@insertar_datos_inscripcion');
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

Route::group(['namespace' => 'paquetes'], function() {
        Route::resource('paquetes', 'PaquetesController');
        Route::get('getPaquetes', 'PaquetesController@getPaquetes');
});

Route::group(['namespace' => 'eventos'], function() {
        Route::resource('eventos', 'EventosController');
        Route::get('getEventos', 'EventosController@getEventos');
        Route::post('createEvento', 'EventosController@createEvento');
        Route::post('editar_evento/{id_evento}', 'EventosController@editar_evento');
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
        Route::get('imprimir_recibo','CajaController@imprimir_recibo');
        Route::get('imprimir_reporte_caja','CajaController@imprimir_reporte_caja');
        
        Route::resource('emision_recibos', 'EmisionRecibosController');
        Route::get('getRecibosProductos', 'EmisionRecibosController@getRecibosProductos');
        Route::get('autocompletar_productos', 'EmisionRecibosController@autocompletar_productos');
});

Route::group(['namespace' => 'configuracion'], function() {
        Route::resource('productos', 'ProductosController');
        Route::get('getProductos', 'ProductosController@getProductos');

        Route::resource('turno', 'TurnosController');
        Route::get('getTurnos', 'TurnosController@getTurnos');
        Route::get('autocompletar_auditorios', 'TurnosController@autocompletar_auditorios');
        
        Route::resource('actividad', 'ActividadController');
        Route::get('getActividad', 'ActividadController@getActividad');
        Route::get('autocompletar_turnos', 'ActividadController@autocompletar_turnos');
        Route::get('autocompletar_ponentes', 'ActividadController@autocompletar_ponentes');
});

Route::group(['namespace' => 'inventario'], function() {
        Route::resource('inventario', 'InventarioController');
        Route::get('getInventario', 'InventarioController@getInventario');
        Route::get('getInventario_entradas', 'InventarioController@getInventario_entradas');
        Route::get('getInventario_salidas', 'InventarioController@getInventario_salidas');

});

Route::group(['namespace' => 'control'], function() {
        Route::resource('credenciales', 'CredencialesController');
        Route::get('getCredenciales', 'CredencialesController@getCredenciales');
        Route::get('ver_credenciales/{id_usuario}', 'CredencialesController@ver_credenciales');
        
        Route::resource('asistencia', 'AsistenciaController');
        Route::get('getAsistencia_persona', 'AsistenciaController@getAsistencia_persona');
        Route::get('recuperar_asistencias', 'AsistenciaController@recuperar_asistencias');
        Route::get('buscar_nro_recibo', 'AsistenciaController@buscar_nro_recibo');
        Route::get('buscar_eventos_by_usuarios', 'AsistenciaController@buscar_eventos_by_usuarios');
        Route::get('autocompletar_materiales', 'AsistenciaController@autocompletar_materiales');
        Route::get('agregar_materiales_asistencia/{id_asistencia}', 'AsistenciaController@agregar_materiales_asistencia');
});

Route::group(['namespace' => 'reportes'], function() {
        Route::resource('reportes', 'ReportesController');
        Route::get('ver_reporte/{tipo}', 'ReportesController@ver_reporte');
});
