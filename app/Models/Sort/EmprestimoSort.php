<?php

namespace App\Models\Sort;

class EmprestimoSort extends Sort
{
    protected $only = ['id', 'devolucao', 'devolvido_em'];

    public function livro($direction)
    {
        $this->query->select('emprestimos.*');
        $this->query->join('livros', 'emprestimos.livro_id', 'livros.id');

        return $this->query->orderBy('livros.titulo', $direction);
    }

    public function estudante($direction)
    {
        $this->query->select('emprestimos.*');
        $this->query->join('estudantes', 'emprestimos.estudante_id', 'estudantes.id');

        return $this->query->orderBy('estudantes.nome', $direction);
    }

}
