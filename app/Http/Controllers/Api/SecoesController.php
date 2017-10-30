<?php

namespace App\Http\Controllers\Api;

use App\Secao;
use App\Http\Resources\SecaoCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SecoesController extends Controller
{
    public function index(Request $request)
    {
        $autores = Secao::whereRaw('UPPER(descricao) LIKE ?',[strtoupper("%{$request->q}%")])->paginate(10);

        return new SecaoCollection($autores);
    }
}
