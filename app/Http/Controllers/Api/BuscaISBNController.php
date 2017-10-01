<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Zttp\Zttp;

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
        $info = Zttp::get("https://www.googleapis.com/books/v1/volumes?q=isbn:{$isbn}")->json();

        if (!$info['totalItems']){
            abort(204);
        }

        return [
            'titulo' => $info['items'][0]['volumeInfo']['title'],
            'autores' => $info['items'][0]['volumeInfo']['authors'],
            'descricao' => $info['items'][0]['volumeInfo']['description'],
            'publicacao' => $info['items'][0]['volumeInfo']['publishedDate'],
            'rating' => $info['items'][0]['volumeInfo']['averageRating'],
            'paginas' => $info['items'][0]['volumeInfo']['pageCount'],
        ];
    }
}
