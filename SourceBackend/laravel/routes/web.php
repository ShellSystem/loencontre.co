<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//**********************////////////////////////////////////administrar/////////////////////////////////////////////*********************
//************************************Articulo
Route::any('/', 'MainController@index');//pide la pagina de añadir archivos
Route::get('pagination', 'MainController@pagination');//pide la pagina 
Route::get('get-page', 'MainController@getPage');

Route::post('load-file', 'MainController@addFromFile');



Auth::routes();