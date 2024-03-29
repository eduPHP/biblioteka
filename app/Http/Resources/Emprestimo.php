<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Emprestimo extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'estudante'=>[
                'id'=> $this->estudante->id,
                'nome'=> $this->estudante->nome,
            ],
            'livro'=>[
                'id'=> $this->livro->id,
                'isbn'=> $this->livro->isbn,
                'titulo'=> $this->livro->titulo,
            ],
            'devolucao'=>optional($this->devolucao)->toDateTimeString(),
            'devolvido'=>$this->devolvido,
            'devolvido_em'=>optional($this->devolvido_em)->toDateTimeString(),
        ];
//        return parent::toArray($request);
    }
}
