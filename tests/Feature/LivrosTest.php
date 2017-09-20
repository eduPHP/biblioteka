<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LivrosTest extends TestCase
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
        $resposta->assertStatus(302)->assertRedirect(url('/livros'));
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

    /** @test */
    function um_usuario_pode_editar_um_livro()
    {
        $this->withoutExceptionHandling();
        //sendo que temos um livro cadastrado
        $livro = factory('App\Livro')->create();

        // devemos ter uma pagina de edição deste livro
        $this->get("/livros/{$livro->id}/edit")->assertStatus(200);

        //quando enviamos as novas informações para o endpoint
        $resposta = $this->patch("/livros/{$livro->id}", [
            'titulo' => $novoTitulo = 'Um novo Título',
            'isbn' => $livro->isbn,
        ]);

        //então devemos ter as informações atualizadas
        $resposta->assertStatus(302)->assertRedirect(url('/livros'));
        $this->assertDatabaseHas('livros', [
            'id' => $livro->id,
            'titulo' => $novoTitulo,
        ]);
    }

    /** @test */
    function um_usuario_pode_visualizar_um_livro()
    {
        //sendo que temos um livro
        $livro = factory('App\Livro')->create();

        //quando acessar o link de visualizacao
        $resposta = $this->get("/livros/{$livro->id}/edit")->assertStatus(200);

        //então devemos ter as informações do livro
        $resposta->assertSee($livro->titulo);
    }
}
