<?php

namespace App\Http\Controllers;

use App\Editora;
use App\Livro;
use App\Secao;
use Illuminate\Http\Request;

class LivrosController extends Controller
{
    /**
     * Lista os Livros
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $livros = Livro::paginate();

        return view('livros.index', compact('livros'));
    }

    /**
     * Cria um novo Livro
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $secoes = Secao::all();
        $editoras = Editora::all();

        return view('livros.create', compact('secoes', 'editoras'));
    }

    /**
     * Grava um novo Livro
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'isbn' => 'required',
            'titulo' => 'required',
            'descricao' => 'nullable',
            'edicao' => 'nullable|numeric',
            'quantidade' => 'required|numeric|min:1',
            'ano' => 'required|year',
            'editora_id' => 'required|exists:editoras,id',
            'secao_id' => 'required|exists:secoes,id',
        ]);

        Livro::create($data);

        return $this->redirectToIndex("Livro adicionado");
    }

    /**
     * Exibe um Livro
     *
     * @param Livro $livro
     *
     * @return \Illuminate\View\View
     */
    public function show(Livro $livro)
    {
        return view('livros.show', compact('livro'));
    }

    /**
     * Edita um Livro
     *
     * @param Livro $livro
     *
     * @return \Illuminate\View\View
     */
    public function edit(Livro $livro)
    {
        $secoes = Secao::all();
        $editoras = Editora::all();

        return view('livros.edit', compact('livro', 'secoes', 'editoras'));
    }

    /**
     * Atualiza um Livro
     *
     * @param Request $request
     * @param Livro $livro
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Livro $livro)
    {
        $data = $request->validate([
            'isbn' => 'required',
            'titulo' => 'required',
        ]);

        $livro->update($data);

        return $this->redirectToIndex("Livro modificado");
    }

    /**
     * Remove um Livro
     *
     * @param Livro $livro
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Livro $livro)
    {
        $livro->delete();

        return $this->redirectToIndex("Livro removido");
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
        return redirect('/livros')->withSuccess($str);
    }

}
