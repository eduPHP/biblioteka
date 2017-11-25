<?php

namespace Tests\Feature;

use App\Estudante;
use App\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstudantesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function uma_adicao_de_estudante_deve_conter_um_nome()
    {
        $this->loginBibliotecario();

        $dados = [
            'matricula' => 123,
        ];

        $resposta = $this->postJson('/api/estudantes', $dados);

        $resposta->assertStatus(422)->assertJsonFragment(['nome']);
    }

    /** @test */
    function uma_adicao_de_estudante_deve_conter_uma_matricula()
    {
        $this->loginBibliotecario();

        $dados = [
            'nome' => 'Eduardo',
        ];

        $resposta = $this->postJson('/api/estudantes', $dados);

        $resposta->assertStatus(422)->assertJsonFragment(['matricula']);
    }

    /** @test */
    function devemos_poder_visualizar_a_lista_de_estudantes_cadastrados()
    {
        $this->loginBibliotecario();

        $estudantes = factory('App\Estudante', 3)->create();

        $resposta = $this->getJson('/api/estudantes');

        $resposta->assertStatus(200);

        foreach ($estudantes as $estudante) {
            $resposta->assertSee(e($estudante->nome));
        }
    }

    /** @test */
    function devemos_poder_consultar_um_estudante_pelo_nome()
    {
        $this->loginBibliotecario();

        factory('App\Estudante', 3)->create();
        factory('App\Estudante')->create(['nome' => 'Alfalfa']);

        $resposta = $this->getJson('/api/estudantes?q=alfalfa');

        $resposta->assertStatus(200);
        $this->assertEquals(1, $resposta->json()['meta']['total']);
    }

    /** @test */
    function devemos_poder_consultar_um_estudante_pela_matricula()
    {
        $this->loginBibliotecario();

        factory('App\Estudante', 3)->create();
        factory('App\Estudante')->create(['matricula' => 545454]);

        $resposta = $this->getJson('/api/estudantes?q=545454');

        $resposta->assertStatus(200);
        $this->assertEquals(1, $resposta->json()['meta']['total']);
    }

    /** @test */
    function um_bibliotecario_pode_listar_estudantes()
    {
        $this->loginBibliotecario();

        $this->getJson('/api/estudantes')
            ->assertStatus(200)
            ->assertJsonFragment(['estudantes']);
    }

    /** @test */
    function um_bibliotecario_pode_adicionar_estudantes()
    {
        $this->loginBibliotecario();

        $this->postJson('/api/estudantes', $dados = [
            'matricula' => 123,
            'nome' => 'Novo Estudante',
        ])->assertStatus(201);

        $this->assertDatabaseHas('estudantes', $dados);
    }

    /** @test */
    function um_bibliotecario_pode_editar_estudantes()
    {
        $this->loginBibliotecario();

        $estudante = factory(Estudante::class)->create();

        $this->patchJson("/api/estudantes/{$estudante->id}", $data = [
            'matricula' => 6666,
            'nome' => 'Changed',
        ])->assertStatus(201);

        $this->assertDatabaseHas('estudantes', $data);
    }

    /** @test */
    function um_bibliotecario_pode_remover_uma_estudante()
    {
        $this->loginBibliotecario();

        $estudante = factory(Estudante::class)->create();

        $this->delete("/api/estudantes/{$estudante->id}")
            ->assertStatus(201);

        $this->assertDatabaseMissing('estudantes', [
            'id' => $estudante->id,
        ]);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_listar_estudantes()
    {
        $this->loginNormal();

        $resposta = $this->getJson('/api/estudantes');

        $resposta->assertStatus(403);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_adicionar_estudantes()
    {
        $this->loginNormal();

        $this->postJson('/api/estudantes', $dados = [
            'matricula' => 123,
            'nome' => 'Novo Estudante',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('estudantes', $dados);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_editar_estudantes()
    {
        $this->loginNormal();

        $estudante = factory(Estudante::class)->create();

        $this->patchJson("/api/estudantes/{$estudante->id}", $data = [
            'matricula' => 333,
            'nome' => 'Changed',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('estudantes', $data);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_remover_uma_estudante()
    {
        $this->loginNormal();

        $estudante = factory(Estudante::class)->create();

        $this->delete("/api/estudantes/{$estudante->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('estudantes', [
            'id' => $estudante->id,
        ]);
    }
}
