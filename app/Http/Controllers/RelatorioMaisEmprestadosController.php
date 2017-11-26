<?php

namespace App\Http\Controllers;

use App\Livro;

class RelatorioMaisEmprestadosController extends Controller
{
    public function index()
    {
        $livros = Livro::relatorioMaisEmprestados();

        return view('relatorios.livros.mais-emprestados', compact('livros'));
    }
}
