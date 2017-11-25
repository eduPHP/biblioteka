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
        $this->authorize('view', Estudante::class);

        return new EstudanteResource(
            Estudante::apiQuery()
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Estudante::class);

        $dados = $request->validate([
            'nome' => 'required',
            'matricula' => 'required',
        ]);

        $estudante = Estudante::create($dados);

        return response(compact('estudante'), 201);
    }

    public function update(Estudante $estudante, Request $request)
    {
        $this->authorize('edit', $estudante);

        $dados = $request->validate([
            'nome' => 'required',
            'matricula' => 'required',
        ]);

        $estudante->update($dados);

        return response(compact('estudante'), 201);
    }

    public function destroy(Estudante $estudante)
    {
        $this->authorize('delete', $estudante);

        try {
            $estudante->delete();
            return response('Estudante removido.', 201);
        } catch (\Exception $exception) {
            return response(['message' => 'Estudante sendo referenciado em algum empréstimo.'], 422);
        }
    }
}
