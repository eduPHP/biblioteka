<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LivrosTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function devemos_poder_adicionar_um_livro()
    {
        $this->withoutExceptionHandling();
        $this->get("/livros/create")->assertStatus(200);

        $novoLivro = factory('App\Livro')->make()->toArray();
        factory('App\Autor')->create();

        $resposta = $this->post('/api/livros', array_merge($novoLivro, ['autores' => [1]]));

        $resposta->assertStatus(201);
        $this->assertDatabaseHas('livros', $novoLivro);
        $this->assertCount(1, \App\Livro::first()->autores);
    }

    /** @test */
    function devemos_poder_listar_livros()
    {
        $livros = factory('App\Livro', 3)->create();

        $resposta = $this->get("/livros");

        foreach ($livros as $livro) {
            $resposta->assertSee(e($livro->titulo));
        }
    }

    /** @test */
    function devemos_poder_editar_um_livro()
    {
        $this->withoutExceptionHandling();
        $livro = factory('App\Livro')->create();

        $this->get("/livros/{$livro->id}/edit")->assertStatus(200);

        $data = $livro->toArray();
        $data['titulo'] = $novoTitulo = 'Um novo Título';
        $data['autores'] = ['Novo Autor'];
        $resposta = $this->patch("/api/livros/{$livro->id}", $data);

        $resposta->assertStatus(201);
        $this->assertDatabaseHas('livros', [
            'id' => $livro->id,
            'titulo' => $novoTitulo,
        ]);
    }

    /** @test */
    function devemos_poder_visualizar_um_livro()
    {
        $livro = factory('App\Livro')->create();

        $resposta = $this->get("/livros/{$livro->id}/edit")->assertStatus(200);

        $resposta->assertSee($livro->titulo);
    }

    /** @test */
    function devemos_poder_remover_um_livro()
    {
        $livro = factory('App\Livro')->create();

        $this->delete("/api/livros/{$livro->id}")->assertStatus(201);

        $this->assertDatabaseMissing('livros', ['id' => $livro->id]);
    }

    /** @test */
    function devemos_poder_consultar_um_livro_por_isbn()
    {
        factory('App\Livro')->create(['isbn' => 4321]);

        $resposta = $this->getJson('/api/livros/4321');

        $resposta->assertStatus(200);
        $this->assertEquals(4321, $resposta->json()['livro']['isbn']);
    }

    /** @test */
    function ao_consultar_um_isbn_nao_cadastrado_deve_retornar_four_oh_four()
    {
        $resposta = $this->getJson('/api/livros/4321');

        $resposta->assertStatus(404);
    }

    /** @test */
    function ao_adicionar_um_livro_quando_enviamos_uma_string_como_autor_este_valor_deve_ser_inserido_no_banco()
    {
        $autorExistente = factory('App\Autor')->create();
        $livro = factory('App\Livro')->make();
        $data = $livro->toArray();
        $data['autores'][] = $autorExistente->id;
        $data['autores'][] = "Novo Autor";

        $resposta = $this->post('/api/livros', $data);

        $resposta->assertStatus(201);
        $this->assertCount(2, \App\Livro::first()->autores);
        $this->assertDatabaseHas('autores', ['nome' => $data['autores'][1]]);
    }

    /** @test */
    function ao_adicionar_um_livro_podemos_informar_o_nome_da_editora_e_este_sera_adicionado_ao_banco()
    {
        $livro = factory('App\Livro')->make(['editora_id' => null]);

        $resposta = $this->post('/api/livros', array_merge($livro->toArray(), [
            'editora_id' => $editora = 'Nova Editora',
            'autores' => [factory('App\Autor')->create()->id]
        ]));

        $resposta->assertStatus(201);
        $this->assertDatabaseHas('editoras', ['nome' => $editora]);
    }

    /** @test */
    function ao_adicionar_um_livro_podemos_informar_o_nome_da_secao_e_este_sera_adicionado_ao_banco()
    {
        $livro = factory('App\Livro')->make(['secao_id' => null]);

        $resposta = $this->post('/api/livros', array_merge($livro->toArray(), [
            'secao_id' => $secao = 'Nova Secao',
            'autores' => [factory('App\Autor')->create()->id]
        ]));

        $resposta->assertStatus(201);
        $this->assertDatabaseHas('secoes', ['descricao' => $secao]);
    }
}
