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
Route::any('/', 'PostController@index');//pide la pagina de añadir archivos
Route::get('pagination', 'PostController@pagination');//pide la pagina 
Route::get('get-page', 'PostController@getPage');
Route::get('date-range', 'PostController@dateRange');
Route::any('add-post', 'PostController@addPost');
Route::any('search-name', 'PostController@searchName');
Route::any('user-posts', 'PostController@userPosts');
Route::any('change-state', 'PostController@changeState');

Route::any('prueba', 'PostController@prueba');

//rutas, postcontroller
Auth::routes();
