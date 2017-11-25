<?php

namespace App\Http\Controllers\Api;

use App\Editora;
use App\Http\Resources\EditoraCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorasController extends Controller
{
    public function index()
    {
        $editoras = Editora::apiQuery();

        return new EditoraCollection($editoras);
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
        $this->authorize('create', Editora::class);

        $data = $request->validate([
            'nome' => 'required'
        ]);

        $editora = Editora::create($data);

        return response(compact('editora'), 201);
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
        $this->authorize('edit', $editora);

        $data = $request->validate([
            'nome' => 'required'
        ]);

        $editora->update($data);

        return response(compact('editora'), 201);
    }


    /**
     * Remove um Editora
     *
     * @param Editora $editora
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Editora $editora)
    {
        $this->authorize('delete', $editora);

        try {
            $editora->delete();
            return response('Removido', 201);
        } catch (\Exception $exception) {
            return response(['message' => 'Editora sendo referenciada em algum livro.'], 422);
        }
    }
}
