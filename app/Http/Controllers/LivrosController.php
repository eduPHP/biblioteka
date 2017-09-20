<?php

namespace App\Http\Controllers;

use App\Livro;
use Illuminate\Http\Request;

class LivrosController extends Controller
{
    public function index()
    {
        $livros = Livro::all();

        return view('livros.index', compact('livros'));
    }

    public function show(Livro $livro)
    {
        return view('livros.show', compact('livro'));
    }

    public function create()
    {
        return view('livros.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo' => 'required',
            'isbn' => 'required',
        ]);

        Livro::create($dados);

        return redirect(url('/livros'))->with('success', 'Livro adicionado');
    }

    public function edit(Livro $livro)
    {
        return view('livros.edit', compact('livro'));
    }

    public function update(Livro $livro, Request $request)
    {
        $dados = $request->validate([
            'titulo' => 'required',
            'isbn' => 'required',
        ]);

        $livro->update($dados);

        return redirect(url('/livros'))->with('success', 'Livro modificado');
    }

    public function destroy(Livro $livro)
    {
        $livro->delete();

        return redirect(url('/livros'))->with('success', 'Livro removido');
    }
}
