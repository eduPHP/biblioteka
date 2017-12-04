<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaisEmprestadosCollection;
use App\Livro;

class RelatorioMaisEmprestadosController extends Controller
{
    public function index()
    {
        $livros = Livro::relatorioMaisEmprestados();

        return new MaisEmprestadosCollection($livros);
    }
}
