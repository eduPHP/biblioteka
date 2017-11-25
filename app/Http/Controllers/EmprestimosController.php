<?php

namespace App\Http\Controllers;

use App\Emprestimo;

class EmprestimosController extends Controller
{
    public function index()
    {
        $this->authorize('view', Emprestimo::class);

        return view('emprestimos.index');
    }


    public function create()
    {
        $this->authorize('create', Emprestimo::class);

        return view('emprestimos.create');
    }

}
