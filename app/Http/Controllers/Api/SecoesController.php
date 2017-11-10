<?php

namespace App\Http\Controllers\Api;

use App\Secao;
use App\Http\Resources\SecaoCollection;
use App\Http\Controllers\Controller;

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

}
