<?php

namespace Tests\Feature;

use App\Autor;
use App\Livro;
use App\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoresTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function devemos_poder_ordenar_autores_pela_quantidade_de_livros()
    {
        factory(Livro::class)->create()->autores()->sync([
            $a1 = factory(Autor::class)->create()->id,
        ]);
        $a2 = factory(Autor::class)->create()->id;
        factory(Livro::class, 2)->create()->each(function ($livro) use ($a2) {
            $livro->autores()->sync([$a2]);
        });

        $response = $this->getJson('/api/autores?orderby=livros_count')->json();

        $this->assertSame($response['autores'][0]['id'], $a1);
        $this->assertSame($response['autores'][1]['id'], $a2);

        $response = $this->getJson('/api/autores?orderby=livros_count,desc')->json();

        $this->assertSame($response['autores'][0]['id'], $a2);
        $this->assertSame($response['autores'][1]['id'], $a1);
    }

    /** @test */
    function podemos_adicionar_um_autor()
    {
        $this->loginBibliotecario();

        $data = factory(Autor::class)->raw();

        $resposta = $this->postJson('/api/autores', $data);

        $resposta->assertStatus(201);
        $this->assertSame($data['nome'], $resposta->json()['autor']['nome']);
    }

    /** @test */
    function podemos_editar_um_autor()
    {
        $this->loginBibliotecario();

        $autor = factory(Autor::class)->create();

        $resposta = $this->patchJson("/api/autores/{$autor->id}", $data = ['nome' => 'John Doe']);

        $resposta->assertStatus(201);
        $this->assertSame($data['nome'], $resposta->json()['autor']['nome']);
    }

    /** @test */
    function podemos_remover_um_autor()
    {
        $this->loginBibliotecario();

        $this->logIn(factory(Usuario::class)->states('bibliotecario')->create());

        $autor = factory(Autor::class)->create();

        $resposta = $this->deleteJson("/api/autores/{$autor->id}");

        $resposta->assertStatus(200);
        $this->assertDatabaseMissing('autores',['id'=>$autor->id]);
    }

    /** @test */
    function o_nome_do_autor_eh_obrigatorio()
    {
        $this->loginBibliotecario();

        $this->logIn(factory(Usuario::class)->states('bibliotecario')->create());

        $resposta = $this->postJson("/api/autores", ['nome' => null]);

        $resposta->assertStatus(422)->assertJsonFragment(['nome']);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_adicionar_autores()
    {
        $this->loginNormal();

        $this->postJson('/api/autores', $dados = [
            'nome' => 'Novo Autor',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('autores', $dados);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_editar_autores()
    {
        $this->loginNormal();

        $editora = factory(Autor::class)->create();

        $this->patchJson("/api/autores/{$editora->id}", $data = [
            'nome' => 'Changed',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('autores', $data);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_remover_uma_editora()
    {
        $this->loginNormal();

        $editora = factory(Autor::class)->create();

        $this->delete("/api/autores/{$editora->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('autores', [
            'id' => $editora->id,
        ]);
    }

}
