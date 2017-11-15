<?php

namespace App\Http\Controllers;

use App\Secao;

class SecoesController extends Controller
{
    /**
     * Lista os Seções
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('secoes.index');
    }

    /**
     * Exibe um Secao
     *
     * @param Secao $secao
     *
     * @return \Illuminate\View\View
     */
    public function show(Secao $secao)
    {
        return view('secoes.show', compact('secao'));
    }
}
