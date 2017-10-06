<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Livro as LivroResource;
use App\Livro;

class LivrosController extends Controller
{
    public function show($isbn)
    {
        if (!$livro = Livro::findByIsbn($isbn)) {
            return response()->json((int)$isbn, 404);
        }

        return new LivroResource($livro);
    }
}
