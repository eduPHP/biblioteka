<?php

namespace App\Http\Controllers;

class LivrosController extends Controller
{
    /**
     * Lista os Livros
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('livros.index');
    }
}
