<?php

namespace App\Http\Controllers\Api;

use App\Autor;
use App\Http\Resources\AutorCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutoresController extends Controller
{
    public function index(Request $request)
    {
        $autores = Autor::whereRaw('UPPER(nome) LIKE ?',[strtoupper("%{$request->q}%")])->paginate(10);

        return new AutorCollection($autores);
    }
}
