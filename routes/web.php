<?php

Route::get('/', "IndexController@index");
Route::get('/teste', "IndexController@vue");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/livros/{livro}', 'LivrosController@show');
Route::get('/api/livros/{isbn}', 'Api\LivrosController@show');
Route::get('/api/livros/busca-isbn/{isbn}', 'Api\BuscaISBNController@show');
Route::patch('/livros/{livro}', 'LivrosController@update');
Route::delete('/livros/{livro}', 'LivrosController@destroy');
Route::get('/livros/{livro}/edit', 'LivrosController@edit');
Route::get('/livros/create', 'LivrosController@create');
Route::get('/livros', 'LivrosController@index');
Route::post('/livros', 'LivrosController@store');

Route::get('/estudantes/{estudante}', 'EstudantesController@show');
Route::patch('/estudantes/{estudante}', 'EstudantesController@update');
Route::get('/estudantes/{estudante}/edit', 'EstudantesController@edit');
Route::delete('/estudantes/{estudante}', 'EstudantesController@destroy');
Route::get('/estudantes/create', 'EstudantesController@create');
Route::get('/estudantes', 'EstudantesController@index');
Route::get('/api/estudantes', 'Api\\EstudantesController@index');
Route::post('/estudantes', 'EstudantesController@store');

Route::get('/emprestimos', 'EmprestimosController@index');
Route::get('/api/emprestimos', 'Api\EmprestimosController@index');
Route::post('/api/emprestimos', 'Api\EmprestimosController@store');
Route::patch('/api/emprestimos/{emprestimo}/devolver', 'EmprestimosController@update');
Route::post('/api/emprestimos/{emprestimo}/renovar', 'RenovacoesController@store');
Route::get('/emprestimos/create', 'EmprestimosController@create');
