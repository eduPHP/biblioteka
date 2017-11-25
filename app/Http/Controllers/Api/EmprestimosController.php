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
        $this->authorize('view', Emprestimo::class);

        return new EmprestimoResource(
            Emprestimo::apiQuery()
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Emprestimo::class);

        $dados = $request->validate([
            'livros' => 'required|exists:livros,id',
            'estudante_id' => 'required|exists:estudantes,id',
            'devolucao' => 'nullable|date_format:d/m/Y',
        ]);

        foreach (array_wrap($dados['livros']) as $livro) {
            $dados['livro_id'] = $livro;
            Emprestimo::emprestar($dados);
        }

        return response('adicionado', 201);
    }

    public function update(Emprestimo $emprestimo)
    {
        $this->authorize('devolver', $emprestimo);

        $emprestimo->devolver();

        return response('devolvido', 201);
    }
}
