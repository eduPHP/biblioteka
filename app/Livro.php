<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $guarded = [];

    public static function findByIsbn($isbn)
    {
        return self::whereIsbn($isbn)->first();
    }

    public static function adicionar($data)
    {
        $autores = array_pull($data,'autores');

        $livro = self::create($data);
        $livro->autores()->sync($autores);

        return $livro;
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livros');
    }
}
