<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function apos_cadastrar_no_sistema_um_usuario_pode_fazer_login()
    {
        $usuario = factory('App\Usuario')->create();

        $this->post('/login', [
            'email' => $usuario->email,
            'password' => 'secret',
        ]);

        $this->assertEquals($usuario->id, auth()->id());
    }


}
