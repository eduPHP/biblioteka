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


    }
}
