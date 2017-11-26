<?php

namespace Tests\Feature;

use App\Emprestimo;
use App\Livro;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelatorioMaisEmprestadosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function gerar_relatorio_de_livros_mais_emprestados()
    {
        $this->withoutExceptionHandling();
        $this->loginBibliotecario();

        factory(Livro::class, 3)->create()->each(function ($livro) {
            factory(Emprestimo::class, rand(1, 3))->create(['livro_id' => $livro->id]);
        });

        $resposta = $this->getJson("/relatorios/mais-emprestados");

        $livros = $resposta->getOriginalContent()->getData()['livros'];
        $numero = $livros[0]->emprestimos_count;
        foreach ($livros as $livro) {
            $resposta->assertSee($livro->titulo);
            $this->assertTrue(
                $livro->emprestimos_count <= $numero,
                'A lista não está ordenada corretamente'
            );
            $numero = $livro->emprestimos_count;
        }
        $this->assertEquals(3, $livros->total());
    }

    /** @test */
    function gerar_relatorio_de_livros_mais_emprestados_em_um_periodo()
    {
        // 3 emprestimos em um periodo
        factory(Emprestimo::class, 3)->create([
            'emprestado_em' => Carbon::now()->subDays(rand(1, 5)),
        ]);

        // 3 emprestimos em um periodo anterior
        factory(Emprestimo::class, 3)->create([
            'emprestado_em' => Carbon::now()->subCentury(),
        ]);

        //quando acessamos relatorios/mais-emprestados?periodo=data1,data2
        $data1 = Carbon::now()->subWeek()->format('d/m/Y');
        $data2 = Carbon::now()->format('d/m/Y');
        $this->loginBibliotecario();
        $resposta = $this->getJson("/relatorios/mais-emprestados?periodo={$data1},{$data2}");

        //então devemos ter uma lista dos livros do primeiro periodo
        $livros = $resposta->getOriginalContent()->getData()['livros'];
        $this->assertEquals(3, $livros->total());
    }

    /** @test */
    function ordenar_relatorio_de_livros_mais_emprestado_por_quantidade_de_emprestimos()
    {
        $this->withoutExceptionHandling();
        //sendo que temos um livro que foi emprestado 1x, e outro que foi emprestado 2x
        $livro1x = factory(Livro::class)->create()->id;
        factory(Emprestimo::class, 1)->create([
            'livro_id' => $livro1x,
            'emprestado_em' => Carbon::now()->subDays(rand(1, 5)),
        ]);
        $livro2x = factory(Livro::class)->create()->id;
        factory(Emprestimo::class, 2)->create([
            'livro_id' => $livro2x,
            'emprestado_em' => Carbon::now()->subDays(rand(1, 5)),
        ]);
        $this->loginBibliotecario();
        //quando acessamos o endpoint relatorios/mais-emprestados?orderby=emprestimos,desc
        $resposta = $this->getJson("/relatorios/mais-emprestados?orderby=emprestimos,desc");

        $livros = $resposta->getOriginalContent()->getData()['livros'];
        //então devemos ter o emprestado 2x no topo da lista
        $this->assertEquals($livro2x, $livros[0]->id);
        $this->assertEquals($livro1x, $livros[1]->id);

        //quando acessamos o endpoint relatorios/mais-emprestados?orderby=emprestimos
        $resposta = $this->getJson("/relatorios/mais-emprestados?orderby=emprestimos");

        $livros = $resposta->getOriginalContent()->getData()['livros'];
        //então devemos ter o emprestado 1x no topo da lista
        $this->assertEquals($livro1x, $livros[0]->id);
        $this->assertEquals($livro2x, $livros[1]->id);
    }
}
