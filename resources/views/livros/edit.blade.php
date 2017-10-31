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
                <span class="icon is-small"><i class="fa fa-plus"></i></span> Editar Livro {{$livro->titulo}}
            </li>
        </ul>
    </nav>
    <h1 class="title">Editar Livro {{$livro->titulo}}</h1>
    <form-livro :livro="{{$livro}}"></form-livro>
@endsection
