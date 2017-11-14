<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoresTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function devemos_poder_ordenar_autores_pela_quantidade_de_livros()
    {
        factory('App\Livro')->create()->autores()->sync([
            $a1 = factory('App\Autor')->create()->id,
        ]);
        $a2 = factory('App\Autor')->create()->id;
        factory('App\Livro', 2)->create()->each(function ($livro) use ($a2) {
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
        $data = factory('App\Autor')->raw();

        $resposta = $this->postJson('/api/autores', $data);

        $resposta->assertStatus(201);
        $this->assertSame($data['nome'], $resposta->json()['autor']['nome']);
    }

    /** @test */
    function podemos_editar_um_autor()
    {
        $autor = factory('App\Autor')->create();

        $resposta = $this->patchJson("/api/autores/{$autor->id}", $data = ['nome' => 'John Doe']);

        $resposta->assertStatus(201);
        $this->assertSame($data['nome'], $resposta->json()['autor']['nome']);
    }

    /** @test */
    function podemos_remover_um_autor()
    {
        $autor = factory('App\Autor')->create();

        $resposta = $this->deleteJson("/api/autores/{$autor->id}");

        $resposta->assertStatus(200);
        $this->assertDatabaseMissing('autores',['id'=>$autor->id]);
    }

    /** @test */
    function o_nome_do_autor_eh_obrigatorio()
    {
        $resposta = $this->postJson("/api/autores", ['nome' => null]);

        $resposta->assertStatus(422)->assertJsonFragment(['nome']);
    }

}
