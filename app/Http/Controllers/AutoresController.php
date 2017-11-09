<?php

namespace App\Http\Controllers;

use App\Autor;
use Illuminate\Http\Request;

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

    /**
     * Cria um novo Autor
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('autores.create');
    }

    /**
     * Grava um novo Autor
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'=>'required'
        ]);

        Autor::create($data);

        return $this->redirectToIndex("Autor adicionado");
    }

    /**
     * Exibe um Autor
     *
     * @param Autor $autor
     *
     * @return \Illuminate\View\View
     */
    public function show(Autor $autor)
    {
        return view('autores.show', compact('autor'));
    }

    /**
     * Edita um Autor
     *
     * @param Autor $autor
     *
     * @return \Illuminate\View\View
     */
    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    /**
     * Atualiza um Autor
     *
     * @param Request $request
     * @param Autor $autor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Autor $autor)
    {
        $data = $request->validate([
            'nome'=>'required'
        ]);

        $autor->update($data);

        return $this->redirectToIndex("Autor modificado");
    }

    /**
     * Redireciona para a listagem
     *
     * @param $str
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToIndex($str)
    {
        return redirect('/autores')->withSuccess($str);
    }

}
