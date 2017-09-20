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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/livros', 'LivrosController@store');
Route::get('/livros', 'LivrosController@index');
Route::get('/livros/create', 'LivrosController@create');
Route::get('/livros/{livro}', 'LivrosController@show');
Route::get('/livros/{livro}/edit', 'LivrosController@edit');
Route::patch('/livros/{livro}', 'LivrosController@update');
Route::delete('/livros/{livro}', 'LivrosController@destroy');


Route::post('/estudantes', 'EstudantesController@store');
Route::get('/estudantes/create', 'EstudantesController@create');
Route::patch('/estudantes/{estudante}', 'EstudantesController@update');
Route::get('/estudantes/{estudante}', 'EstudantesController@show');
Route::get('/estudantes/{estudante}/edit', 'EstudantesController@edit');
Route::get('/estudantes', 'EstudantesController@index');
Route::delete('/estudantes/{estudante}', 'EstudantesController@destroy');
