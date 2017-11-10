<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CadastroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function um_usuario_pode_se_cadastrar()
    {
        $dados = [
            'nome' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->post('/register', $dados);

        $this->assertDatabaseHas('usuarios', ['email' => 'john@example.com']);
    }
}
