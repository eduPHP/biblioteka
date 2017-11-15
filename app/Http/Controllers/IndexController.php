<?php

namespace App\Http\Controllers;

use App\Livro;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
