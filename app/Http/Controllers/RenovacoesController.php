<?php

namespace App\Http\Controllers;

use App\Emprestimo;

class RenovacoesController extends Controller
{
    public function store(Emprestimo $emprestimo)
    {
        $emprestimo->renovar();

        $devolucao = ucfirst($emprestimo->fresh()->devolucao->toDateTimeString());

        return response(compact('devolucao'), 200);
    }
}
