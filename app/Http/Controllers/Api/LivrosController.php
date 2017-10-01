<?php

namespace App\Http\Controllers\Api;

use App\Livro;
use App\Http\Resources\Livro as LivroResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LivrosController extends Controller
{
    public function show($isbn)
    {
        if (!$livro = Livro::findByIsbn($isbn)){
            abort(404);
        }

        return new LivroResource($livro);
    }
}
