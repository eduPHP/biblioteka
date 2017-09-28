<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EstudantesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function um_usuario_pode_adicionar_um_estudante()
    {
        $dados = [
            'nome' => 'Eduardo',
            'matricula' => 123,
        ];

        $this->get('/estudantes/create')->assertStatus(200);

        $resposta = $this->post('/estudantes', $dados);

        $resposta->assertStatus(302)->assertRedirect('/estudantes');
        $this->assertDatabaseHas('estudantes', $dados);

    }

    /** @test */
    function uma_adicao_de_estudante_deve_conter_um_nome()
    {
        $dados = [
            'matricula' => 123,
        ];

        $resposta = $this->post('/estudantes', $dados);

        $resposta->assertStatus(302)->assertSessionHasErrors('nome');
    }

    /** @test */
    function uma_adicao_de_estudante_deve_conter_uma_matricula()
    {
        $dados = [
            'nome' => 'Eduardo',
        ];

        $resposta = $this->post('/estudantes', $dados);

        $resposta->assertStatus(302)->assertSessionHasErrors('matricula');
    }

    /** @test */
    function um_usuario_pode_editar_um_estudante()
    {
        $estudante = factory('App\Estudante')->create();

        $this->get("/estudantes/{$estudante->id}/edit")->assertStatus(200);

        $resposta = $this->patch("/estudantes/{$estudante->id}", [
            'nome' => $novoNome = 'Teste',
            'matricula' => $estudante->matricula,
        ]);

        $resposta->assertStatus(302)->assertRedirect('/estudantes');
        $this->assertDatabaseHas('estudantes', [
            'id' => $estudante->id,
            'nome' => $novoNome,
        ]);
    }

    /** @test */
    function um_usuario_pode_visualizar_a_lista_de_estudantes_cadastrados()
    {
        $estudantes = factory('App\Estudante', 3)->create();

        $resposta = $this->get('/estudantes');

        $resposta->assertStatus(200);

        foreach ($estudantes as $estudante) {
            $resposta->assertSee(e($estudante->nome));
        }
    }

    /** @test */
    function um_usuario_pode_visualizar_um_estudante()
    {
        $estudante = factory('App\Estudante')->create();

        $resposta = $this->get("/estudantes/{$estudante->id}");

        $resposta->assertStatus(200)->assertSee($estudante->nome);
    }

    /** @test */
    function um_usuario_pode_remover_um_estudante()
    {
        $estudante = factory('App\Estudante')->create();

        $resposta = $this->delete("/estudantes/{$estudante->id}");

        $resposta->assertStatus(302)->assertRedirect('/estudantes')->assertSessionHas('success');
        $this->assertDatabaseMissing('estudantes', ['id' => $estudante->id]);
    }

}
