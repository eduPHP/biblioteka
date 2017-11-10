<?php

namespace App\Http\Controllers;

use App\Editora;
use Illuminate\Http\Request;

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
     * Cria um novo Editora
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('editoras.create');
    }

    /**
     * Grava um novo Editora
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

        Editora::create($data);

        return $this->redirectToIndex("Editora adicionada");
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

    /**
     * Edita um Editora
     *
     * @param Editora $editora
     *
     * @return \Illuminate\View\View
     */
    public function edit(Editora $editora)
    {
        return view('editoras.edit', compact('editora'));
    }

    /**
     * Atualiza um Editora
     *
     * @param Request $request
     * @param Editora $editora
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Editora $editora)
    {
        $data = $request->validate([
            'nome'=>'required'
        ]);

        $editora->update($data);

        return $this->redirectToIndex("Editora modificada");
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
        return redirect('/editoras')->withSuccess($str);
    }
}
