<?php

namespace App\Http\Controllers\Api;

use App\Emprestimo;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmprestimoCollection as EmprestimoResource;
use Illuminate\Http\Request;

class EmprestimosController extends Controller
{
    public function index()
    {
        return new EmprestimoResource(
            Emprestimo::apiQuery()
        );
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'livros' => 'required|exists:livros,id',
            'estudante_id' => 'required|exists:estudantes,id',
            'devolucao' => 'nullable|date',
        ]);

        foreach (array_wrap($dados['livros']) as $livro) {
            $dados['livro_id'] = $livro;
            Emprestimo::emprestar($dados);
        }

        return response('adicionado', 201);
    }
}
