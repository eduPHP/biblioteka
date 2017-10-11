<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';
    protected $guarded = [];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livros');
    }
}
