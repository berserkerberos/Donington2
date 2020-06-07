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
    //    session_start();
    header('location: ingreso');
    exit;
});

/********* DEMOS */
Route::get('ejem/demo', function () {
    return view('ejem/demo');
});
Route::get('ejem/iconos', function () {
    return view('ejem/iconos');
});
Route::get('msgError', function () {
    return view('frmMsgError');
});

/*Controll login**/
Route::get('/ingreso', 'loginController@login')
    ->name("padron.ingreso");

Route::get('/cerrarSession', 'loginController@logout');

Route::post('/validaUsuario', 'loginController@validaUsuario')
    ->name("padron.validaUsuario");


/*Todos*/
Route::group(['middleware' => "valPermisos:1_2_3"], function () {
    /*Rutas para todos**/
    Route::get('/inicio', 'loginController@inicio')
        ->name("padron.inicio");
    /* actualizacion de usuario **/
    Route::get('/configUsu', 'loginController@configUsu')
        ->name("padron.configUsu");
    Route::post('/actualizaUsuario', 'loginController@actualizaUsuario')
        ->name("padron.actualizaUsuario");

    Route::resource('transferencia', 'transferenciaController');
    Route::match(['get', 'post'], 'trans/descargar', 'transferenciaController@descargarBanco');
    Route::post('trans/copiar', 'transferenciaController@copiar');
    Route::post('transBorrar/{id}', 'transferenciaController@destroy')->where('id', '[0-9]+');
});

/* solo admin */
Route::group(['middleware' => "valPermisos:1"], function () {
    /*registro de nuevos usuarios**/
    Route::resource('usuario', 'UsuarioController');
});
