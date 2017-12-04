<?php

namespace App\Http\Controllers;

use App\Livro;
use Illuminate\Support\Facades\Cache;

class RelatorioMaisEmprestadosController extends Controller
{
    public function index()
    {
        return view('relatorios.livros.mais-emprestados');
    }

    public function show()
    {
        return Cache::remember(auth()->id().'.mais-emprestados.'.md5(json_encode(request()->all())), 10, function (){
            $livros = Livro::relatorioMaisEmprestados(1000);

            $pdf = \PDF::loadView('relatorios.livros.mais-emprestados-print', compact('livros'));

            return $pdf->stream();
        });
    }
}
