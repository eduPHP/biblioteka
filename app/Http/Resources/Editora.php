<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Editora extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        self::wrap('editoras');
        return [
            'id'=>$this->id,
            'nome'=>$this->nome,
        ];
    }
}
