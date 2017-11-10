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
            $a1 = factory('App\Autor')->create()->id
        ]);
        $a2 = factory('App\Autor')->create()->id;
        factory('App\Livro',2)->create()->each(function ($livro) use($a2){
            $livro->autores()->sync([$a2]);
        });

        $response = $this->getJson('/api/autores?orderby=livros_count')->json();

        $this->assertSame($response['autores'][0]['id'], $a1);
        $this->assertSame($response['autores'][1]['id'], $a2);

        $response = $this->getJson('/api/autores?orderby=livros_count,desc')->json();

        $this->assertSame($response['autores'][0]['id'], $a2);
        $this->assertSame($response['autores'][1]['id'], $a1);
    }
}
