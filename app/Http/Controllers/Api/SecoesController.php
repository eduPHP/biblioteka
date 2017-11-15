<?php

namespace App\Http\Controllers\Api;

use App\Secao;
use App\Http\Resources\SecaoCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SecoesController extends Controller
{
    public function index()
    {
        $autores = Secao::apiQuery();

        return new SecaoCollection($autores);
    }

    /**
     * Remove um Secao
     *
     * @param Secao $secao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Secao $secao)
    {
        try {
            $secao->delete();
            return response('Removido');
        } catch (\Exception $exception) {
            return response(['message' => 'Seção sendo referenciada em algum livro.'], 422);
        }
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
            'descricao' => 'required',
            'localizacao' => 'nullable'
        ]);

        $secao = Secao::create($data);

        return response(compact('secao'), 201);
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
            'descricao' => 'required',
            'localizacao' => 'nullable'
        ]);

        $secao->update($data);

        return response(compact('secao'), 201);
    }
}
