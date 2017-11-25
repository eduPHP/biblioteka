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
        $this->authorize('view', Secao::class);

        return view('secoes.index');
    }
}
