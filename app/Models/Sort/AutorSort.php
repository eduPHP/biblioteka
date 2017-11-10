<?php

namespace App\Models\Sort;

class AutorSort extends Sort
{
    protected $only = ['id', 'nome'];

    public function livrosCount($direction)
    {
        $query =  $this->query->selectRaw('autores.*, COUNT(autor_livros.id) as livros_count')
            ->leftJoin('autor_livros','autores.id','autor_livros.autor_id')
            ->groupBy(['autores.id'])
            ->orderBy('livros_count', $direction);
//        dd($query->toSql());
    }
}
