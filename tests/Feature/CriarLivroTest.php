<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CriarLivroTest extends TestCase
{
    use DatabaseMigrations, InteractsWithExceptionHandling;

    /** @test */
    function um_usuario_pode_adicionar_um_livro()
    {
        //sendo que temos um usuário logado
        $this->logIn();
        $this->withoutExceptionHandling();

        // quando acessamos a criacao de livros devemos ter um formulario
        $this->get("/livros/create")->assertStatus(200);

        //quando enviamos os dados para cadastro
        $resposta = $this->post("/livros", $dados = [
            'titulo' => 'A volta dos que não foram',
            'isbn' => 12345,
        ]);

        //então o livro deve estar presente no banco
        $resposta->assertStatus(200);
        $this->assertDatabaseHas('livros', $dados);
    }

    /** @test */
    function um_usuario_pode_listar_livros()
    {
        $this->logIn();
        $this->withoutExceptionHandling();
        //sendo que temos varios livros
        $livros = factory('App\Livro', 3)->create();

        //quando acessamos o index
        $resposta = $this->get("/livros");

        //então devemos ter os livros na lista
        foreach ($livros as $livro) {
            $resposta->assertSee($livro->titulo);
        }
    }


}
