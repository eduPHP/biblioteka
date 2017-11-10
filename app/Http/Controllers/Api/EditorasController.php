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
     * Remove um Editora
     *
     * @param Editora $editora
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Editora $editora)
    {
        try {
            $editora->delete();
            return response('Removido');
        } catch (\Exception $exception) {
            return response(['message' => 'Editora sendo referenciada em algum livro.'], 422);
        }
    }
}
