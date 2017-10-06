<?php

namespace App;

use App\Models\Traits\Sortable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use Sortable;

    public $timestamps = false;
    protected $dates = ['emprestado_em', 'devolvido_em', 'devolucao'];
    protected $guarded = [];
    protected $appends = ['devolvido'];

    public static function emprestar($dados)
    {
        $dados['devolucao'] = isset($dados['devolucao']) ? Carbon::createFromFormat('d/m/Y',$dados['devolucao']) : Carbon::now()->addWeek();
        $dados['emprestado_em'] = Carbon::now();
        unset($dados['livros']);

        return static::create($dados);
    }

    public static function apiQuery()
    {
        $query = self::with(['estudante', 'livro'])->ordered();

        if ($search = request('q')) {
            $query->whereHas('estudante', function ($query) use ($search) {
                $query->whereRaw('UPPER(nome) like ?', [strtoupper("%{$search}%")]);
            })->orWhereHas('livro', function ($query) use ($search) {
                $query->whereRaw('(UPPER(titulo) like ? or isbn = ?)', [strtoupper("%{$search}%"), $search]);
            });
        }

        return $query->paginate(request('perpage', 10));
    }

    public function devolver()
    {
        return $this->update(['devolvido_em' => Carbon::now()]);
    }

    public function renovar()
    {
        return $this->update([
            'devolucao' => Carbon::now()->addWeek(),
            'devolvido_em' => null,
        ]);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function estudante()
    {
        return $this->belongsTo(Estudante::class);
    }

    public function getDevolvidoAttribute()
    {
        return $this->devolvido_em != null;
    }
}
