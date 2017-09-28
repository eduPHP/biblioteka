<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EmprestimosTest extends TestCase
{
    use DatabaseMigrations, InteractsWithExceptionHandling;

    /** @test */
    function um_usuario_pode_cadastrar_um_emprestimo()
    {
        $this->get("/emprestimos/create")->assertStatus(200);

        $livro = factory('App\Livro')->create();
        $estudante = factory('App\Estudante')->create();

        $resposta = $this->post("/emprestimos", $data = [
            'livros' => $livro->id,
            'estudante_id' => $estudante->id,
        ]);

        $resposta->assertRedirect("/emprestimos");
        $resposta->assertSessionHas('success');
        $this->assertDatabaseHas('emprestimos', [
            'livro_id' => $livro->id,
            'estudante_id' => $estudante->id,
        ]);
    }

    /** @test */
    function um_usuario_pode_cadastrar_emprestimo_de_multiplos_livros()
    {
        $livros = factory('App\Livro', 3)->create();
        $estudante = factory('App\Estudante')->create();

        $resposta = $this->post("/emprestimos", $data = [
            'livros' => [$livros[0]->id, $livros[1]->id, $livros[2]->id,],
            'estudante_id' => $estudante->id,
        ]);

        $resposta->assertRedirect('/emprestimos');
        foreach ($livros as $livro) {
            $this->assertDatabaseHas('emprestimos', [
                'livro_id' => $livro->id,
                'estudante_id' => $estudante->id,
            ]);
        }
    }

    /** @test */
    function um_usuario_pode_realizar_devolucao_de_um_emprestimo()
    {
        $emprestimo = factory('App\Emprestimo')->create();

        $resposta = $this->patch("/emprestimos/{$emprestimo->id}/devolver");

        $resposta->assertStatus(202);
        $this->assertNotNull($emprestimo->fresh()->devolvido_em);
    }

    /** @test */
    function um_usuario_pode_realizar_renovacao_de_um_emprestimo()
    {
        $emprestimo = factory('App\Emprestimo')->create();

        $response = $this->post("/emprestimos/{$emprestimo->id}/renovar");

        $response->assertStatus(200)->assertJsonStructure(['devolucao']);
        $this->assertDatabaseHas('emprestimos', [
            'devolucao' => Carbon::now()->addWeek(),
        ]);
    }

    /** @test */
    function um_usuario_pode_listar_os_livros_emprestados()
    {
        $emprestimos = factory('App\Emprestimo', 3)->create();

        $resposta = $this->get('/emprestimos');

        $resposta->assertStatus(200);
        foreach ($emprestimos as $emprestimo) {
            $resposta->assertSee(e($emprestimo->estudante->nome));
            $resposta->assertSee(e($emprestimo->livro->titulo));
        }
    }

}
