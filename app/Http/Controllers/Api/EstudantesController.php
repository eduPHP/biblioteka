<?php

namespace App\Http\Controllers\Api;

use App\Estudante;
use App\Http\Resources\EstudanteCollection as EstudanteResource;
use App\Http\Controllers\Controller;

class EstudantesController extends Controller
{
    public function index()
    {
        return new EstudanteResource(
            Estudante::apiQuery()
        );
    }

    public function destroy(Estudante $estudante)
    {
        try {
            $estudante->delete();
            return response('Estudante removido.');
        } catch (\Exception $exception) {
            return response(['message' => 'Estudante sendo referenciado em algum empréstimo.'], 422);
        }
    }
}
