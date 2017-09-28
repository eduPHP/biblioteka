<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LivrosTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function um_usuario_pode_adicionar_um_livro()
    {
        $this->get("/livros/create")->assertStatus(200);

        $resposta = $this->post("/livros", $dados = [
            'titulo' => 'A volta dos que não foram',
            'isbn' => 12345,
        ]);

        $resposta->assertStatus(302)->assertRedirect(url('/livros'));
        $this->assertDatabaseHas('livros', $dados);
    }

    /** @test */
    function um_usuario_pode_listar_livros()
    {
        $livros = factory('App\Livro', 3)->create();

        $resposta = $this->get("/livros");

        foreach ($livros as $livro) {
            $resposta->assertSee(e($livro->titulo));
        }
    }

    /** @test */
    function um_usuario_pode_editar_um_livro()
    {
        $livro = factory('App\Livro')->create();

        $this->get("/livros/{$livro->id}/edit")->assertStatus(200);

        $resposta = $this->patch("/livros/{$livro->id}", [
            'titulo' => $novoTitulo = 'Um novo Título',
            'isbn' => $livro->isbn,
        ]);

        $resposta->assertStatus(302)->assertRedirect(url('/livros'));
        $this->assertDatabaseHas('livros', [
            'id' => $livro->id,
            'titulo' => $novoTitulo,
        ]);
    }

    /** @test */
    function um_usuario_pode_visualizar_um_livro()
    {
        $livro = factory('App\Livro')->create();

        $resposta = $this->get("/livros/{$livro->id}/edit")->assertStatus(200);

        $resposta->assertSee($livro->titulo);
    }

    /** @test */
    function um_usuario_pode_remover_um_livro()
    {
        $livro = factory('App\Livro')->create();

        $resposta = $this->delete("/livros/{$livro->id}")->assertStatus(302);

        $resposta->assertRedirect('/livros');
        $this->assertDatabaseMissing('livros', ['id' => $livro->id]);
    }
}
