<?php

namespace App\Http\Controllers;

use App\Estudante;

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
}
