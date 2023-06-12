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

Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes(['register' => false]);
Route::permanentRedirect('/register', '/login');

Route::permanentRedirect('/home', '/crm');

//Route spa
Route::get('crm/{path?}', "SpaController@index")->where('path', '([A-z0-9-\/_.]+)?')->name('spa');

//Routes for consume data
Route::prefix('rest')->name('rest.')->group(function () {

    Route::get('user/select', 'UserController@select')->name('user.select');
    Route::resource('user', 'UserController');

    Route::get('rol/select', 'RolController@select')->name('rol.select');
    Route::resource('rol', 'RolController')->except(['show', 'create']);

    Route::get('cuenta/select', 'CuentaController@select')->name('cuenta.select');
    Route::resource('cuenta', 'CuentaController')->except(['show', 'create']);
    Route::get('campania/select', 'CampaniaController@select')->name('campania.select');
    Route::resource('campania', 'CampaniaController')->except(['show', 'create']);

    Route::get('cliente/exportarexcel', 'ClienteController@exportarExcel')->name('cuenta.exportarexcel');
    Route::post('cliente/importarexcel', 'ClienteController@importarExcel')->name('cuenta.importarexcel');
    Route::post('cliente/physicallyremove', 'ClienteController@physicallyRemove')->name('cliente.physicallyremove');
    Route::resource('cliente', 'ClienteController')->except(['show', 'create']);
    
    Route::get('ubigeo/index', 'UbigeoController@index')->name('ubigeo.index');
    Route::get('ubigeo/departamentos', 'UbigeoController@departamentos')->name('ubigeo.departamentos');
    Route::get('ubigeo/provincias', 'UbigeoController@provincias')->name('ubigeo.provincias');
    Route::get('ubigeo/distritos', 'UbigeoController@distritos')->name('ubigeo.distritos');
    Route::get('ubigeo/distritosleccionados', 'UbigeoController@distritosleccionados')->name('ubigeo.distritosleccionados');

    Route::get('tipoAtencion/select', 'TipoAtencionController@select')->name('tipoAtencion.select');
    Route::resource('tipoAtencion', 'TipoAtencionController')->except(['show', 'create']);  
    
    Route::get('atencion/detail/{id}', 'AtencionController@detail')->name('tipoAtencion.detail');
    Route::resource('atencion', 'AtencionController')->except(['show', 'create']);  
    
    Route::resource('import', 'ImportacionController')->except(['show', 'create']);  
    Route::resource('logerror', 'LogErrorController')->except(['show', 'create']);
    
});
