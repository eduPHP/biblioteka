<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Livro extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        self::wrap('livros');
        return [
            'id'=>$this->id,
            'isbn'=>$this->isbn,
            'quantidade'=>$this->quantidade,
            'autores'=>$this->autores->map(function ($autor){
                return [
                    'id'=>$autor->id,
                    'nome'=>$autor->nome,
                ];
            }),
            'titulo'=>$this->titulo,
            'descricao'=>$this->descricao,
            'editora_id'=>$this->editora_id,
            'secao_id'=>$this->secao_id,
            'ano'=>$this->ano,
            'edicao'=>$this->edicao,
        ];
    }
}
