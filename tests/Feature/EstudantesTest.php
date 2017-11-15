<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstudantesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function devemos_poder_adicionar_um_estudante()
    {
        $dados = [
            'nome' => 'Eduardo',
            'matricula' => 123,
        ];

        $resposta = $this->postJson('/api/estudantes', $dados);

        $resposta->assertStatus(201);
        $this->assertDatabaseHas('estudantes', $dados);

    }

    /** @test */
    function uma_adicao_de_estudante_deve_conter_um_nome()
    {
        $dados = [
            'matricula' => 123,
        ];

        $resposta = $this->postJson('/api/estudantes', $dados);

        $resposta->assertStatus(422)->assertJsonFragment(['nome']);
    }

    /** @test */
    function uma_adicao_de_estudante_deve_conter_uma_matricula()
    {
        $dados = [
            'nome' => 'Eduardo',
        ];

        $resposta = $this->postJson('/api/estudantes', $dados);

        $resposta->assertStatus(422)->assertJsonFragment(['matricula']);
    }

    /** @test */
    function devemos_poder_editar_um_estudante()
    {
        $estudante = factory('App\Estudante')->create();

        $resposta = $this->patchJson("/api/estudantes/{$estudante->id}", [
            'nome' => $novoNome = 'Teste',
            'matricula' => $estudante->matricula,
        ]);

        $resposta->assertStatus(201);
        $this->assertDatabaseHas('estudantes', [
            'id' => $estudante->id,
            'nome' => $novoNome,
        ]);
    }

    /** @test */
    function devemos_poder_visualizar_a_lista_de_estudantes_cadastrados()
    {
        $estudantes = factory('App\Estudante', 3)->create();

        $resposta = $this->getJson('/api/estudantes');

        $resposta->assertStatus(200);

        foreach ($estudantes as $estudante) {
            $resposta->assertSee(e($estudante->nome));
        }
    }

    /** @test */
    function devemos_poder_visualizar_um_estudante()
    {
        $estudante = factory('App\Estudante')->create();

        $resposta = $this->get("/estudantes/{$estudante->id}");

        $resposta->assertStatus(200)->assertSee($estudante->nome);
    }

    /** @test */
    function devemos_poder_remover_um_estudante()
    {
        $estudante = factory('App\Estudante')->create();

        $resposta = $this->deleteJson("/api/estudantes/{$estudante->id}");

        $resposta->assertStatus(200);
        $this->assertDatabaseMissing('estudantes', ['id' => $estudante->id]);
    }

    /** @test */
    function devemos_poder_consultar_um_estudante_pelo_nome()
    {
        factory('App\Estudante', 3)->create();
        factory('App\Estudante')->create(['nome' => 'Alfalfa']);

        $resposta = $this->getJson('/api/estudantes?q=alfalfa');

        $resposta->assertStatus(200);
        $this->assertEquals(1, $resposta->json()['meta']['total']);
    }

    /** @test */
    function devemos_poder_consultar_um_estudante_pela_matricula()
    {
        $this->withoutExceptionHandling();
        factory('App\Estudante', 3)->create();
        factory('App\Estudante')->create(['matricula' => 545454]);

        $resposta = $this->getJson('/api/estudantes?q=545454');

        $resposta->assertStatus(200);
        $this->assertEquals(1, $resposta->json()['meta']['total']);
    }
}
