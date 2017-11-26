<?php

namespace Tests\Feature;

use App\Emprestimo;
use App\Estudante;
use App\Livro;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmprestimosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function um_bibliotecario_pode_listar_emprestimos()
    {
        $this->loginBibliotecario();

        $this->getJson('/api/emprestimos')
            ->assertStatus(200)
            ->assertJsonFragment(['emprestimos']);
    }

    /** @test */
    function um_bibliotecario_pode_adicionar_emprestimos()
    {
        $this->loginBibliotecario();

        $estudante = factory(Estudante::class)->create()->id;
        $livros = [factory(Livro::class)->create()->id];

        $this->postJson('/api/emprestimos', $dados = [
            'livros' => $livros,
            'estudante_id' => $estudante,
            'devolucao' => ($devolucao = Carbon::now()->addDays(7))->format('d/m/Y'),
        ])->assertStatus(201);

        $this->assertDatabaseHas('emprestimos', [
            'estudante_id' => $estudante,
            'devolucao' => $devolucao,
        ]);
    }


    /** @test */
    function um_bibliotecario_pode_adicionar_emprestimo_de_multiplos_livros()
    {
        $this->loginBibliotecario();

        $estudante = factory(Estudante::class)->create()->id;
        $livros = factory('App\Livro', 3)->create()->map(function ($livro) {
            return $livro->id;
        });

        $this->postJson('/api/emprestimos', $dados = [
            'livros' => $livros,
            'estudante_id' => $estudante,
            'devolucao' => ($devolucao = Carbon::now()->addDays(7))->format('d/m/Y'),
        ])->assertStatus(201);

        foreach ($livros as $livro) {
            $this->assertDatabaseHas('emprestimos', [
                'livro_id' => $livro,
                'estudante_id' => $estudante,
            ]);
        }
    }

    /** @test */
    function um_bibliotecario_pode_realizar_a_devolucao_do_emprestimo()
    {
        $this->loginBibliotecario();

        $emprestimo = factory(Emprestimo::class)->create();

        $this->patchJson("/api/emprestimos/{$emprestimo->id}/devolver")
            ->assertStatus(201);

        $this->assertNotNull($emprestimo->fresh()->devolvido_em);
    }

    /** @test */
    function um_bibliotecario_pode_renovar_um_emprestimo()
    {
        $this->loginBibliotecario();

        $emprestimo = factory(Emprestimo::class)->create([
            'devolucao' => Carbon::now(),
        ]);

        $this->postJson("/api/emprestimos/{$emprestimo->id}/renovar")
            ->assertStatus(201);

        $this->assertSame(
            $emprestimo->fresh()->devolucao->toDateTimeString(),
            Carbon::now()->addDays(7)->toDateTimeString()
        );
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_listar_emprestimos()
    {
        $this->loginNormal();

        $resposta = $this->getJson('/api/emprestimos');

        $resposta->assertStatus(403);
    }

    /** @test */
    function usuarios_nao_autorizados_nao_podem_adicionar_emprestimos()
    {
        $this->loginNormal();

        $this->postJson('/api/emprestimos', $dados = [
            'livros' => 1,
        ])->assertStatus(403);

        $this->assertDatabaseMissing('emprestimos', $dados);
    }


    /** @test */
    function devemos_poder_filtrar_a_lista_de_emprestimos_por_uma_keyword()
    {
        $this->loginBibliotecario();

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
        $this->loginBibliotecario();
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
        $this->loginBibliotecario();
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
        $this->loginBibliotecario();
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
        $this->loginBibliotecario();
        $devolvido = factory('App\Emprestimo')->create([
            'devolucao' => Carbon::now()->addDay(),
            'devolvido_em' => Carbon::now(),
        ]);
        $naoDevolvido = factory('App\Emprestimo')->create(['devolucao' => Carbon::now()->addWeek()]);

        $resposta = $this->getJson('/api/emprestimos');

        $this->assertSame($naoDevolvido->id, $resposta->json()['emprestimos'][0]['id']);
        $this->assertSame($devolvido->id, $resposta->json()['emprestimos'][1]['id']);
    }
}
