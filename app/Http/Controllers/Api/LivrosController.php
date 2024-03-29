<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Livro as LivroResource;
use App\Http\Resources\LivroCollection;
use App\Livro;
use Illuminate\Http\Request;

class LivrosController extends Controller
{
    public function index()
    {
        $livros = Livro::apiQuery();

        return new LivroCollection($livros);
    }

    public function show($isbn)
    {
        if (!$livro = Livro::findByIsbn($isbn)) {
            return response($isbn, 404);
        }

        return new LivroResource($livro);
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
        $this->authorize('create', Livro::class);

        $data = $request->validate([
            'isbn' => 'required',
            'titulo' => 'required',
            'descricao' => 'nullable',
            'edicao' => 'nullable|numeric',
            'quantidade' => 'required|numeric|min:1',
            'ano' => 'required|date_format:Y',
            'editora_id' => 'required',
            'secao_id' => 'required',
            'autores' => 'required|array'
        ]);

        $livro = Livro::adicionar($data);

        return response(compact('livro'), 201);
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
        $this->authorize('edit', $livro);

        $data = $request->validate([
            'isbn' => 'required',
            'titulo' => 'required',
            'descricao' => 'nullable',
            'edicao' => 'nullable|numeric',
            'quantidade' => 'required|numeric|min:1',
            'ano' => 'required|date_format:Y',
            'editora_id' => 'required',
            'secao_id' => 'required',
            'autores' => 'required|array'
        ]);

        $livro = $livro->atualizar($data);

        return response(compact('livro'), 201);
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
        $this->authorize('delete', $livro);

        $livro->delete();

        return response('Removido', 201);
    }
}
