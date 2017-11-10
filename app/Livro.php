<?php

namespace App;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use Sortable;

    protected $guarded = [];
    protected $orderby = "titulo";

    public static function findByIsbn($isbn)
    {
        return self::whereIsbn($isbn)->first();
    }

    public static function adicionar($data)
    {
        list($data, $autores) = self::prepareData($data);

        $livro = self::create($data);
        $livro->autores()->sync($autores);

        return $livro;
    }

    public static function apiQuery()
    {
        $query = self::ordered();

        if ($search = request('q')) {
            $query->whereRaw(
                '(UPPER(titulo) like ? or isbn = ?)',
                [strtoupper("%$search%"), $search]
            );
        }

        return $query->paginate(request('perpage', 10));
    }

    public function atualizar($data)
    {
        list($data, $autores) = self::prepareData($data);

        $this->update($data);
        $this->autores()->sync($autores);

        return $this->fresh();
    }

    /**
     * @param $data
     *
     * @return array
     */
    protected static function prepareData($data)
    {
        $autores = array_pull($data, 'autores');
        $editora = array_pull($data, 'editora_id');
        $secao = array_pull($data, 'secao_id');

        foreach ($autores as $k => $autor) {
            if (is_string($autor)) {
                $autores[$k] = Autor::create(['nome' => $autor])->id;
            }
        }

        $data['editora_id'] = is_string($editora) ? Editora::create(['nome' => $editora])->id : $editora;
        $data['secao_id'] = is_string($secao) ? Secao::create(['descricao' => $secao])->id : $secao;

        return [$data, $autores];
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livros');
    }

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    public function secao()
    {
        return $this->belongsTo(Secao::class);
    }
}
