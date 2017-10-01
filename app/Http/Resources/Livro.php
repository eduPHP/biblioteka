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
        self::wrap('livro');
        return parent::toArray($request);
    }
}
