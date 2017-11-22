<?php

namespace App\Http\Controllers\Api;

use App\Autor;
use App\Editora;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class BuscaISBNController extends Controller
{
    public function show($isbn)
    {
        return $this->getBookInfo($isbn);
    }

    /**
     * @param $isbn
     *
     * @return mixed
     */
    protected function getBookInfo($isbn)
    {
        $client = new Client();
        try {
            $response = $client->get("https://www.googleapis.com/books/v1/volumes", [
                'query' => [
                    'q' => "isbn:{$isbn}",
                ],
            ]);
            $info = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            $info = [
                'totalItems' => 0,
            ];
        }

        if (!$info['totalItems']) {
            abort(204);
        }

        $volume = $info['items'][0]['volumeInfo'];

        $autores = [];

        foreach (array_wrap($volume['authors']) as $autor){
            $busca = Autor::whereNome($autor)->first();
            $autores[] = $busca ?? ['nome' => $autor];
        }
        $editora = null;
        if (isset($volume['publisher'])){
            $busca = Editora::whereNome($volume['publisher'])->first();
            $editora = $busca ?? ['nome' => $volume['publisher']];
        }
        return [
            'titulo' => $volume['title'],
            'autores' => $autores,
            'descricao' => $volume['description'] ?? '',
            'publicacao' => $volume['publishedDate'] ?? '',
            'editora' => $editora,
            'rating' => $volume['averageRating'] ?? '',
            'paginas' => $volume['pageCount'],
        ];
    }
}
