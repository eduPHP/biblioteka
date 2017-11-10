<?php

namespace App\Http\Controllers;

use App\Emprestimo;

class EmprestimosController extends Controller
{
    public function index()
    {
        return view('emprestimos.index');
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
