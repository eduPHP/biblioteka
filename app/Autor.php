<?php

namespace App;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use Sortable;

    protected $table = 'autores';
    protected $guarded = [];
    protected $orderby = 'nome';

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livros');
    }

    public static function apiQuery()
    {
        $query = self::ordered();

        if ($search = request('q')) {
            $query->whereRaw('UPPER(nome) LIKE ?', [strtoupper("%{$search}%")]);
        }

        return $query->paginate(request('perpage', 10));
    }

}
