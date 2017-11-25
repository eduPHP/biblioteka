<?php

namespace Tests;

use App\Usuario;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function logIn($usuario = null)
    {
        if ( !$usuario) {
            $usuario = factory('App\Usuario')->create();
        }

        auth()->login($usuario);

        return $this;
    }

    public function loginBibliotecario()
    {
        $bibliotecario = factory(Usuario::class)->states('bibliotecario')->create();

        $this->logIn($bibliotecario);
    }

    public function loginNormal()
    {
        $usuario = factory(Usuario::class)->create();

        $this->logIn($usuario);
    }
}
