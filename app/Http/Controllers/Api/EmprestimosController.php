<?php

namespace App\Http\Controllers\Api;

use App\Emprestimo;
use App\Http\Resources\EmprestimoCollection as EmprestimoResource;
use App\Http\Controllers\Controller;

class EmprestimosController extends Controller
{
    public function index()
    {
        return new EmprestimoResource(
            Emprestimo::apiQuery()
        );
    }
}
