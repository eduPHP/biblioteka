<?php

namespace App\Http\Controllers\Api;

use App\Editora;
use App\Http\Resources\EditoraCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorasController extends Controller
{
    public function index(Request $request)
    {
        $autores = Editora::whereRaw('UPPER(nome) LIKE ?',[strtoupper("%{$request->q}%")])->paginate(10);

        return new EditoraCollection($autores);
    }
}
