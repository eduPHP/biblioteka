<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmprestimosTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    function devemos_poder_cadastrar_um_emprestimo()
    {
        $this->get("/emprestimos/create")->assertStatus(200);

        $livro = factory('App\Livro')->create();
        $estudante = factory('App\Estudante')->create();

        $this->post("/api/emprestimos", $data = [
            'livros' => $livro->id,
            'estudante_id' => $estudante->id,
        ]);

        $this->assertDatabaseHas('emprestimos', [
            'livro_id' => $livro->id,
            'estudante_id' => $estudante->id,
        ]);
    }

    /** @test */
    function devemos_poder_cadastrar_emprestimo_de_multiplos_livros()
    {
        $livros = factory('App\Livro', 3)->create();
        $estudante = factory('App\Estudante')->create();

        $this->post("/api/emprestimos", $data = [
            'livros' => [$livros[0]->id, $livros[1]->id, $livros[2]->id,],
            'estudante_id' => $estudante->id,
        ]);

        foreach ($livros as $livro) {
            $this->assertDatabaseHas('emprestimos', [
                'livro_id' => $livro->id,
                'estudante_id' => $estudante->id,
            ]);
        }
    }

    /** @test */
    function devemos_poder_realizar_devolucao_de_um_emprestimo()
    {
        $emprestimo = factory('App\Emprestimo')->create();

        $resposta = $this->patch("/api/emprestimos/{$emprestimo->id}/devolver");

        $resposta->assertStatus(202);
        $this->assertNotNull($emprestimo->fresh()->devolvido_em);
    }

    /** @test */
    function devemos_poder_realizar_renovacao_de_um_emprestimo()
    {
        $emprestimo = factory('App\Emprestimo')->create();

        $response = $this->post("/api/emprestimos/{$emprestimo->id}/renovar");

        $response->assertStatus(200)->assertJsonStructure(['devolucao']);
        $this->assertDatabaseHas('emprestimos', [
            'devolucao' => Carbon::now()->addWeek(),
        ]);
    }

    /** @test */
    function devemos_poder_listar_os_livros_emprestados()
    {
        $emprestimos = factory('App\Emprestimo', 3)->create();

        $resposta = $this->get('/api/emprestimos');

        $resposta->assertStatus(200);
        foreach ($emprestimos as $emprestimo) {
            $resposta->assertJsonFragment([$emprestimo->estudante->nome]);
            $resposta->assertJsonFragment([$emprestimo->livro->titulo]);
        }
    }

    /** @test */
    function devemos_poder_filtrar_a_lista_de_emprestimos_por_uma_keyword()
    {
        $emprestimos = factory('App\Emprestimo', 3)->create();
        $emprestimos[1]->livro->update(['titulo' => 'foobar', 'isbn' => 123456]);
        $emprestimos[0]->estudante->update(['nome' => 'johndoe']);
        $emprestimos[1]->estudante->update(['nome' => 'johndoe']);

        $resposta = $this->getJson('/api/emprestimos?q=foobar');

        $this->assertEquals(1, $resposta->json()['meta']['total']);

        $resposta = $this->getJson('/api/emprestimos?q=johndoe');

        $this->assertEquals(2, $resposta->json()['meta']['total']);

        $resposta = $this->getJson('/api/emprestimos?q=123456');

        $this->assertEquals(1, $resposta->json()['meta']['total']);
    }

    /** @test */
    function devemos_poder_ordenar_emprestimos_por_titulo_do_livro()
    {
        $emprestimos = factory('App\Emprestimo', 3)->create();
        $emprestimos[0]->livro->update(['titulo' => 'bbb']);
        $emprestimos[1]->livro->update(['titulo' => 'ccc']);
        $emprestimos[2]->livro->update(['titulo' => 'aaa']);

        $resposta = $this->getJson('/api/emprestimos?orderby=livro')->json();

        $this->assertSame('aaa', $resposta['emprestimos'][0]['livro']['titulo']);
        $this->assertSame('bbb', $resposta['emprestimos'][1]['livro']['titulo']);
        $this->assertSame('ccc', $resposta['emprestimos'][2]['livro']['titulo']);

        $resposta = $this->getJson('/api/emprestimos?orderby=livro,desc')->json();

        $this->assertSame('ccc', $resposta['emprestimos'][0]['livro']['titulo']);
        $this->assertSame('bbb', $resposta['emprestimos'][1]['livro']['titulo']);
        $this->assertSame('aaa', $resposta['emprestimos'][2]['livro']['titulo']);
    }

    /** @test */
    function devemos_poder_ordenar_emprestimos_por_nome_do_estudante()
    {
        $emprestimos = factory('App\Emprestimo', 3)->create();
        $emprestimos[0]->estudante->update(['nome' => 'bbb']);
        $emprestimos[1]->estudante->update(['nome' => 'ccc']);
        $emprestimos[2]->estudante->update(['nome' => 'aaa']);

        $resposta = $this->getJson('/api/emprestimos?orderby=estudante')->json();

        $this->assertSame('aaa', $resposta['emprestimos'][0]['estudante']['nome']);
        $this->assertSame('bbb', $resposta['emprestimos'][1]['estudante']['nome']);
        $this->assertSame('ccc', $resposta['emprestimos'][2]['estudante']['nome']);

        $resposta = $this->getJson('/api/emprestimos?orderby=estudante,desc')->json();

        $this->assertSame('ccc', $resposta['emprestimos'][0]['estudante']['nome']);
        $this->assertSame('bbb', $resposta['emprestimos'][1]['estudante']['nome']);
        $this->assertSame('aaa', $resposta['emprestimos'][2]['estudante']['nome']);
    }

    /** @test */
    function devemos_poder_ordenar_emprestimos_por_data_de_devolucao()
    {
        $emprestimos = factory('App\Emprestimo', 3)->create();
        $emprestimos[2]->update(['devolucao' => $primeiro = Carbon::now()->addDays(1)]);
        $emprestimos[0]->update(['devolucao' => $segundo = Carbon::now()->addDays(2)]);
        $emprestimos[1]->update(['devolucao' => $terceiro = Carbon::now()->addDays(3)]);

        $resposta = $this->getJson('/api/emprestimos?orderby=devolucao')->json();

        $this->assertSame($primeiro->toDateTimeString(), $resposta['emprestimos'][0]['devolucao']);
        $this->assertSame($segundo->toDateTimeString(), $resposta['emprestimos'][1]['devolucao']);
        $this->assertSame($terceiro->toDateTimeString(), $resposta['emprestimos'][2]['devolucao']);

        $resposta = $this->getJson('/api/emprestimos?orderby=devolucao,desc')->json();

        $this->assertSame($terceiro->toDateTimeString(), $resposta['emprestimos'][0]['devolucao']);
        $this->assertSame($segundo->toDateTimeString(), $resposta['emprestimos'][1]['devolucao']);
        $this->assertSame($primeiro->toDateTimeString(), $resposta['emprestimos'][2]['devolucao']);
    }

    /** @test */
    function emprestimos_devolvidos_devem_ir_para_o_final_da_lista()
    {
        $devolvido = factory('App\Emprestimo')->create([
            'devolucao' => Carbon::now()->addDay(),
            'devolvido_em' => Carbon::now(),
        ]);
        $naoDevolvido = factory('App\Emprestimo')->create(['devolucao' => Carbon::now()->addWeek()]);

        $resposta = $this->getJson('/api/emprestimos');

        $this->assertSame($naoDevolvido->id,$resposta->json()['emprestimos'][0]['id']);
        $this->assertSame($devolvido->id,$resposta->json()['emprestimos'][1]['id']);
    }
}
