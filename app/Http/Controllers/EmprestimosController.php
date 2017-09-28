<?php

namespace App\Http\Controllers;

use App\Emprestimo;
use Illuminate\Http\Request;

class EmprestimosController extends Controller
{
    public function index()
    {
        $emprestimos = Emprestimo::with(['estudante', 'livro'])->orderBy('emprestado_em', 'desc')->paginate();

        return view('emprestimos.index', compact('emprestimos'));
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

        return redirect('/emprestimos')->with('success', "Emprestimo adicionado");
    }

    public function create()
    {
        return view('emprestimos.create');
    }

    public function update(Emprestimo $emprestimo)
    {
        $emprestimo->devolver();

        return response('devolvido', 202);
    }
}
