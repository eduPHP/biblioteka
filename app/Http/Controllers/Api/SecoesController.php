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
        $this->authorize('view', Secao::class);

        $autores = Secao::apiQuery();

        return new SecaoCollection($autores);
    }

    /**
     * Remove uma Secao
     *
     * @param Secao $secao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Secao $secao)
    {
        $this->authorize('delete', $secao);

        try {
            $secao->delete();
            return response('Removido', 201);
        } catch (\Exception $exception) {
            return response(['message' => 'Seção sendo referenciada em algum livro.'], 422);
        }
    }

    /**
     * Grava uma nova Secao
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Secao::class);

        $data = $request->validate([
            'descricao' => 'required',
            'localizacao' => 'nullable'
        ]);

        $secao = Secao::create($data);

        return response(compact('secao'), 201);
    }

    /**
     * Atualiza uma Secao
     *
     * @param Request $request
     * @param Secao $secao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Secao $secao)
    {
        $this->authorize('create', $secao);

        $data = $request->validate([
            'descricao' => 'required',
            'localizacao' => 'nullable'
        ]);

        $secao->update($data);

        return response(compact('secao'), 201);
    }
}
