<?php

namespace App\Http\Controllers;

use App\Editora;

class EditorasController extends Controller
{
    /**
     * Lista os Editoras
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('editoras.index');
    }

    /**
     * Exibe um Editora
     *
     * @param Editora $editora
     *
     * @return \Illuminate\View\View
     */
    public function show(Editora $editora)
    {
        return view('editoras.show', compact('editora'));
    }
}
