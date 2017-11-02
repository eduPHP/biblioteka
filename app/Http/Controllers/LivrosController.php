<?php

namespace App\Http\Controllers;

use App\Livro;

class LivrosController extends Controller
{
    /**
     * Lista os Livros
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $livros = Livro::paginate();

        return view('livros.index', compact('livros'));
    }

    /**
     * Cria um novo Livro
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('livros.create');
    }

    /**
     * Exibe um Livro
     *
     * @param Livro $livro
     *
     * @return \Illuminate\View\View
     */
    public function show(Livro $livro)
    {
        return view('livros.show', compact('livro'));
    }

    /**
     * Edita um Livro
     *
     * @param Livro $livro
     *
     * @return \Illuminate\View\View
     */
    public function edit(Livro $livro)
    {
        return view('livros.edit', ['livro'=>$livro->load('autores','editora','secao')]);
    }

}
