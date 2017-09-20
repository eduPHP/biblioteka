<?php

namespace Tests;

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
    }
}
