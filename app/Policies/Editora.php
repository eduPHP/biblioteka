<?php

namespace App\Policies;

use App\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class Editora
{
    use HandlesAuthorization;

    public function view(Usuario $usuario)
    {
        return true;
    }

    public function edit(Usuario $usuario, \App\Editora $editora = null)
    {
        return in_array($usuario->grupo, ['admin', 'bibliotecario']);
    }

    public function delete(Usuario $usuario, \App\Editora $editora)
    {
        return $this->edit($usuario);
    }

    public function create(Usuario $usuario)
    {
        return $this->edit($usuario);
    }
}
