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
}
