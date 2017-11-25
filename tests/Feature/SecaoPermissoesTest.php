<?php

namespace Tests\Feature;

use App\Secao;
use App\Usuario;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecaoPermissoesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function um_bibliotecario_pode_listar_secoes()
    {
        $this->loginBibliotecario();

        $this->getJson('/api/secoes')
            ->assertStatus(200)
            ->assertJsonFragment(['secoes']);
    }

    /** @test */
    function um_bibliotecario_pode_adicionar_secoes()
    {
        $this->loginBibliotecario();

        $this->postJson('/api/secoes', $dados = [
            'descricao' => 'Nova Secao',
        ])->assertStatus(201);

        $this->assertDatabaseHas('secoes', $dados);
    }

    /** @test */
    function um_bibliotecario_pode_editar_secoes()
    {
        $this->loginBibliotecario();

        $secao = factory(Secao::class)->create();

        $this->patchJson("/api/secoes/{$secao->id}", $data = [
            'descricao' => 'Changed',
        ])->assertStatus(201);

        $this->assertDatabaseHas('secoes', $data);
    }

    /** @test */
    function um_bibliotecario_pode_remover_uma_secao()
    {
        $this->loginBibliotecario();

        $secao = factory(Secao::class)->create();

        $this->delete("/api/secoes/{$secao->id}")
            ->assertStatus(201);

        $this->assertDatabaseMissing('secoes', [
            'id' => $secao->id,
        ]);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_listar_secoes()
    {
        $this->loginNormal();

        $resposta = $this->getJson('/api/secoes');

        $resposta->assertStatus(403);
    }


    /** @test */
    function usuarios_nao_autorizados_nao_podem_adicionar_secoes()
    {
        $this->loginNormal();

        $this->postJson('/api/secoes', $dados = [
            'descricao' => 'Nova Secao',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('secoes', $dados);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_editar_secoes()
    {
        $this->loginNormal();

        $secao = factory(Secao::class)->create();

        $this->patchJson("/api/secoes/{$secao->id}", $data = [
            'descricao' => 'Changed',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('secoes', $data);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_remover_uma_secao()
    {
        $this->loginNormal();

        $secao = factory(Secao::class)->create();

        $this->delete("/api/secoes/{$secao->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('secoes', [
            'id' => $secao->id,
        ]);
    }
}
