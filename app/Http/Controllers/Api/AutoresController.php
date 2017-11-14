<?php

namespace App\Http\Controllers\Api;

use App\Autor;
use App\Http\Resources\AutorCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutoresController extends Controller
{
    public function index()
    {
        return new AutorCollection(Autor::apiQuery());
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
            'nome' => 'required'
        ]);

        $autor = Autor::create($data);

        return response(compact('autor'), 201);
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
            'nome' => 'required'
        ]);

        $autor->update($data);

        return response(compact('autor'), 201);
    }

    /**
     * Remove um Autor
     *
     * @param Autor $autor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Autor $autor)
    {
        try {
            $autor->delete();
            return response('Removido');
        } catch (\Exception $exception) {
            return response(['message' => 'Autor sendo referenciado em algum livro.'], 422);
        }
    }

}
