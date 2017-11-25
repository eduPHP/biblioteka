<?php

Route::get('/', "IndexController@index")->name('home');

Auth::routes();

Route::group(['middleware'=>'auth'], function (){
    Route::get('/api/livros/busca-isbn/{isbn}', 'Api\BuscaISBNController@show');
    Route::patch('/api/livros/{livro}', 'Api\LivrosController@update');
    Route::delete('/api/livros/{livro}', 'Api\LivrosController@destroy');
    Route::post('/api/livros', 'Api\LivrosController@store');

    Route::get('/estudantes/{estudante}', 'EstudantesController@show');
    Route::patch('/api/estudantes/{estudante}', 'Api\EstudantesController@update');
    Route::delete('/api/estudantes/{estudante}', 'Api\EstudantesController@destroy');
    Route::get('/estudantes', 'EstudantesController@index');
    Route::get('/api/estudantes', 'Api\EstudantesController@index');
    Route::post('/api/estudantes', 'Api\EstudantesController@store');

    Route::get('/emprestimos', 'EmprestimosController@index');
    Route::get('/emprestimos/create', 'EmprestimosController@create');
    Route::get('/api/emprestimos', 'Api\EmprestimosController@index');
    Route::post('/api/emprestimos', 'Api\EmprestimosController@store');
    Route::patch('/api/emprestimos/{emprestimo}/devolver', 'Api\EmprestimosController@update');
    Route::post('/api/emprestimos/{emprestimo}/renovar', 'Api\RenovacoesController@store');

    Route::get('/secoes', 'SecoesController@index');
    Route::get('/api/secoes', 'Api\SecoesController@index');
    Route::post('/api/secoes', 'Api\SecoesController@store');
    Route::get('/secoes/{secao}', 'SecoesController@show');
    Route::patch('/api/secoes/{secao}', 'Api\SecoesController@update');
    Route::delete('/api/secoes/{secao}', 'Api\SecoesController@destroy');

    Route::get('/editoras', 'EditorasController@index');
    Route::get('/api/editoras', 'Api\EditorasController@index');
    Route::post('/api/editoras', 'Api\EditorasController@store');
    Route::get('/editoras/{editora}', 'EditorasController@show');
    Route::patch('/api/editoras/{editora}', 'Api\EditorasController@update');
    Route::delete('/api/editoras/{editora}', 'Api\EditorasController@destroy');

    Route::post('/api/autores', 'Api\AutoresController@store');
    Route::patch('/api/autores/{autor}', 'Api\AutoresController@update');
    Route::delete('/api/autores/{autor}', 'Api\AutoresController@destroy');
});
//Route::get('/home', 'HomeController@index');
Route::get('/info', 'HomeController@info');

Route::get('/acervo', 'LivrosController@index');
Route::get('/api/livros/{isbn}', 'Api\LivrosController@show');
Route::get('/api/livros', 'Api\LivrosController@index');


Route::get('/api/autores','Api\AutoresController@index');
Route::get('/autores', 'AutoresController@index');
