<?php

namespace App\Policies;

use App\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class Estudante
{
    use HandlesAuthorization;


    public function view(Usuario $usuario)
    {
        return in_array($usuario->grupo, ['admin', 'bibliotecario']);
    }

    public function edit(Usuario $usuario, \App\Estudante $estudante)
    {
        return $this->view($usuario);
    }

    public function delete(Usuario $usuario, \App\Estudante $estudante)
    {
        return $this->view($usuario);
    }

    public function create(Usuario $usuario)
    {
        return $this->view($usuario);
    }
}
