<?php

namespace App\Http\Controllers\Api;

use App\Estudante;
use App\Http\Resources\EstudanteCollection as EstudanteResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstudantesController extends Controller
{
    public function index()
    {
        return new EstudanteResource(
            Estudante::apiQuery()
        );
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required',
            'matricula' => 'required',
        ]);

        $estudante = Estudante::create($dados);

        return response(compact('estudante'), 201);
    }

    public function update(Estudante $estudante, Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required',
            'matricula' => 'required',
        ]);

        $estudante->update($dados);

        return response(compact('estudante'), 201);
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
