<?php

namespace App\Http\Controllers\Api;

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

        return [
            'titulo' => $volume['title'],
            'autores' => $volume['authors'],
            'descricao' => isset($volume['description']) ? $volume['description'] : '',
            'publicacao' => $volume['publishedDate'],
            'rating' => isset($volume['averageRating']) ? $volume['averageRating'] : '',
            'paginas' => $volume['pageCount'],
        ];
    }
}
