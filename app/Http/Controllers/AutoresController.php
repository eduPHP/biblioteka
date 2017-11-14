<?php

namespace App\Http\Controllers;

class AutoresController extends Controller
{
    /**
     * Lista os Autores
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('autores.index');
    }
}
