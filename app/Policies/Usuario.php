<?php

namespace App\Policies;

use App\Usuario as Logado;
use Illuminate\Auth\Access\HandlesAuthorization;

class Usuario
{
    use HandlesAuthorization;

    public function viewRelatorios(Logado $usuario)
    {
        return in_array($usuario->grupo,['admin','bibliotecario']);
    }
}
