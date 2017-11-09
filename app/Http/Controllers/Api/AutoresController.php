<?php

namespace App\Http\Controllers\Api;

use App\Autor;
use App\Http\Resources\AutorCollection;
use App\Http\Controllers\Controller;

class AutoresController extends Controller
{
    public function index()
    {
        return new AutorCollection(Autor::apiQuery());
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
