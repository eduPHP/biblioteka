<?php

namespace App\Http\Controllers;

use App\Secao;
use Illuminate\Http\Request;

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
     * Cria um novo Secao
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('secoes.create');
    }

    /**
     * Grava um novo Secao
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'descricao'=>'required',
            'localizacao'=>'nullable'
        ]);

        Secao::create($data);

        return $this->redirectToIndex("Seção adicionada");
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

    /**
     * Edita um Secao
     *
     * @param Secao $secao
     *
     * @return \Illuminate\View\View
     */
    public function edit(Secao $secao)
    {
        return view('secoes.edit', compact('secao'));
    }

    /**
     * Atualiza um Secao
     *
     * @param Request $request
     * @param Secao $secao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Secao $secao)
    {
        $data = $request->validate([
            'descricao'=>'required',
            'localizacao'=>'nullable'
        ]);

        $secao->update($data);

        return $this->redirectToIndex("Seção modificada");
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
        return redirect('/secoes')->withSuccess($str);
    }

}
