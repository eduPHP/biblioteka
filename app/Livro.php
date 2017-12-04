<?php

namespace App;

use App\Models\Traits\Sortable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use Sortable;

    protected $guarded = [];
    protected $orderby = "titulo";
    protected $appends = ['disponiveis'];

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

    public static function relatorioMaisEmprestados($limit = 10)
    {
        $query = self::selectRaw('livros.*,
          COUNT(emprestimos.id) as emprestimos_count,
          max(emprestimos.emprestado_em) as ultimo_emprestimo, 
          min(emprestimos.emprestado_em) as primeiro_emprestimo')
            ->join('emprestimos', 'livros.id', 'emprestimos.livro_id')
            ->groupBy('livros.id')
            ->ordered('emprestimos,desc');

        if (request('periodo')) {
            list($inicio, $final) = explode(',', request('periodo'));

            $inicio = $inicio ?
                Carbon::createFromFormat('d/m/Y', $inicio)->startOfDay():
                Carbon::now()->startOfMonth()->startOfDay();
            $final = $final ?
                Carbon::createFromFormat('d/m/Y', $final)->endOfDay():
                Carbon::now()->endOfDay();

            $query->whereBetween('emprestado_em', [$inicio, $final]);
        }

        return $query->paginate(request('perpage', $limit));
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

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    public function secao()
    {
        return $this->belongsTo(Secao::class);
    }

    public function getDisponiveisAttribute()
    {
        if (!$this->exists){
            return 0;
        }

        return $this->quantidade - $this->emprestimos()->count();
    }
}
