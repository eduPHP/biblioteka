@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span> </a>
            </li>
            <li>
                <a href="{{ url('/livros') }}"> <span class="icon is-small"><i class="fa fa-book"></i></span> <span>Livros</span>
                </a>
            </li>
            <li class="is-active">
                <span class="icon is-small"><i class="fa fa-plus"></i></span>Livro {{$livro->titulo}}
            </li>
        </ul>
    </nav>
    <h1 class="title">Livro {{$livro->titulo}}</h1>
    <p><strong>ISBN:</strong> {{$livro->isbn}}</p>
    <p><strong>Titulo:</strong> {{$livro->titulo}}</p>
@endsection
