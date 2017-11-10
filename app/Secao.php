<?php

namespace App;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Secao extends Model
{
    use Sortable;

    protected $table = 'secoes';
    protected $guarded = [];
    protected $orderby = "descricao";

    public static function apiQuery()
    {
        $query = self::ordered();

        if ($search = request('q')) {
            $query->whereRaw('UPPER(descricao) like ?', [strtoupper("%$search%")]);
        }

        return $query->paginate(request('perpage', 10));
    }

}
