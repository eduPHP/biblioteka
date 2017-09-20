<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    protected $dates = ['emprestado_em', 'devolvido_em'];
    protected $guarded = [];
}
