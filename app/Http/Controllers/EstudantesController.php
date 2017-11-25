<?php

namespace App\Http\Controllers;

use App\Estudante;

class EstudantesController extends Controller
{
    public function index()
    {
        $this->authorize('view' ,Estudante::class);

        return view('estudantes.index');
    }
}
