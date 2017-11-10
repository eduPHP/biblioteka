<?php

namespace App\Http\Controllers;

use App\Estudante;
use Illuminate\Http\Request;

class EstudantesController extends Controller
{
    public function index()
    {
        return view('estudantes.index');
    }

    public function show(Estudante $estudante)
    {
        return view('estudantes.show', compact('estudante'));
    }

    public function create()
    {
        return view('estudantes.create');
    }

    public function edit(Estudante $estudante)
    {
        return view('estudantes.edit', compact('estudante'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required',
            'matricula' => 'required',
        ]);

        Estudante::create($dados);

        return redirect(url('/estudantes'))->with('success', 'Estudante adicionado');
    }

    public function update(Estudante $estudante, Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required',
            'matricula' => 'required',
        ]);

        $estudante->update($dados);

        return redirect(url('/estudantes'))->with('success', 'Estudante modificado');
    }

}
