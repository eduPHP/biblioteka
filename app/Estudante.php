<?php

namespace App;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Estudante extends Model
{
    use Sortable;

    protected $guarded = [];
    protected $orderby = "nome";

    public static function apiQuery()
    {
        $query = self::ordered();

        if ($search = request('q')) {
            $query->whereRaw('(UPPER(nome) like ? or matricula = ?)', [strtoupper("%$search%"), $search]);
        }

        return $query->paginate(request('perpage', 10));
    }
}
