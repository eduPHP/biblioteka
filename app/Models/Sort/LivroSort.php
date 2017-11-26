<?php

namespace App\Models\Sort;

class LivroSort extends Sort
{
    protected $only = ['id', 'titulo', 'isbn'];

    public function emprestimos($direction)
    {
        return $this->query->orderBy('emprestimos_count', $direction);
    }
}
