<?php

namespace App\Policies;

use App\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class Emprestimo
{
    use HandlesAuthorization;

    public function view(Usuario $usuario)
    {
        return in_array($usuario->grupo, ['admin', 'bibliotecario']);
    }

    public function create(Usuario $usuario)
    {
        return $this->view($usuario);
    }

    public function devolver(Usuario $usuario)
    {
        return $this->view($usuario);
    }

    public function renovar(Usuario $usuario)
    {
        return $this->view($usuario);
    }

}
