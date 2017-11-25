<?php

namespace App\Policies;

use App\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class Autor
{
    use HandlesAuthorization;

    public function view(Usuario $usuario)
    {
        return true;
    }

    public function edit(Usuario $usuario, \App\Autor $autor = null)
    {
        return in_array($usuario->grupo, ['admin', 'bibliotecario']);
    }

    public function delete(Usuario $usuario, \App\Autor $autor)
    {
        return $this->edit($usuario);
    }

    public function create(Usuario $usuario)
    {
        return $this->edit($usuario);
    }

}
