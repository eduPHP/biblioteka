<?php

namespace Tests\Feature;

use App\Editora;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditorasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function uma_adicao_de_editora_deve_conter_um_nome()
    {
        $this->loginBibliotecario();

        $dados = [];

        $resposta = $this->postJson('/api/editoras', $dados);

        $resposta->assertStatus(422)->assertJsonFragment(['nome']);
    }

    /** @test */
    function devemos_poder_visualizar_a_lista_de_editoras_cadastradas()
    {
        $this->loginNormal();

        $editoras = factory('App\Editora', 3)->create();

        $resposta = $this->getJson('/api/editoras');

        $resposta->assertStatus(200);

        foreach ($editoras as $editora) {
            $resposta->assertSee(e($editora->nome));
        }
    }

    /** @test */
    function devemos_poder_consultar_uma_editora_pelo_nome()
    {
        $this->loginNormal();

        factory('App\Editora', 3)->create();
        factory('App\Editora')->create(['nome' => 'Alfalfa']);

        $resposta = $this->getJson('/api/editoras?q=alfalfa');

        $resposta->assertStatus(200);
        $this->assertEquals(1, $resposta->json()['meta']['total']);
    }

    /** @test */
    function um_bibliotecario_pode_adicionar_editoras()
    {
        $this->loginBibliotecario();

        $this->postJson('/api/editoras', $dados = [
            'nome' => 'Nova Editora',
        ])->assertStatus(201);

        $this->assertDatabaseHas('editoras', $dados);
    }

    /** @test */
    function um_bibliotecario_pode_editar_editoras()
    {
        $this->withoutExceptionHandling();
        $this->loginBibliotecario();

        $editora = factory(Editora::class)->create();

        $this->patchJson("/api/editoras/{$editora->id}", $data = [
            'nome' => 'Changed',
        ])->assertStatus(201);

        $this->assertDatabaseHas('editoras', $data);
    }

    /** @test */
    function um_bibliotecario_pode_remover_uma_editora()
    {
        $this->loginBibliotecario();

        $editora = factory(Editora::class)->create();

        $this->delete("/api/editoras/{$editora->id}")
            ->assertStatus(201);

        $this->assertDatabaseMissing('editoras', [
            'id' => $editora->id,
        ]);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_adicionar_editoras()
    {
        $this->loginNormal();

        $this->postJson('/api/editoras', $dados = [
            'matricula' => 123,
            'nome' => 'Nova Editora',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('editoras', $dados);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_editar_editoras()
    {
        $this->loginNormal();

        $editora = factory(Editora::class)->create();

        $this->patchJson("/api/editoras/{$editora->id}", $data = [
            'matricula' => 333,
            'nome' => 'Changed',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('editoras', $data);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_remover_uma_editora()
    {
        $this->loginNormal();

        $editora = factory(Editora::class)->create();

        $this->deleteJson("/api/editoras/{$editora->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('editoras', [
            'id' => $editora->id,
        ]);
    }
}
