<?php

namespace App\Http\Controllers\Api;

use App\Emprestimo;
use App\Http\Controllers\Controller;

class RenovacoesController extends Controller
{
    public function store(Emprestimo $emprestimo)
    {
        $this->authorize('renovar', $emprestimo);

        $emprestimo->renovar();

        $devolucao = ucfirst($emprestimo->fresh()->devolucao->toDateTimeString());

        return response(compact('devolucao'), 201);
    }
}
