<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Tests\TestCase;

/**
 * @group integration
 *
 * Class ConsultaISBNTest
 * @package Tests\Feature
 */
class ConsultaISBNTest extends TestCase
{
    use InteractsWithExceptionHandling;
    /** @test */
    function devemos_poder_consultar_um_isbn_no_google_books()
    {
        //sendo que temos um isbn real 9788533613379
        //quando acessamos nosso endpoint responsavel
        $resposta = $this->getJson('/api/livros/busca-isbn/9788533613379');

        //então devemos ter as informações do livro, com titulo "Senhor Dos Aneis, O - a Sociedade Do Anel - Vol 1"
        $resposta->assertStatus(200);
        $resposta->assertJson(['titulo' => 'Senhor Dos Aneis, O - a Sociedade Do Anel - Vol 1']);
    }

    /** @test */
    function retorna_two_oh_four_em_caso_de_isbn_inexistente()
    {
        //sendo que temos um isbn que nao vai ter resultados
        //quando pesquisamos
        $resposta = $this->getJson('/api/livros/busca-isbn/010101010101');
        //então devemos ter 204
        $resposta->assertStatus(204);
    }
}
