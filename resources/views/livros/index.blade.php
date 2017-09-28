@extends('layouts.app')
@section('content')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span>
                </a>
            </li>
            <li class="is-active">
                <a><span class="icon is-small"><i class="fa fa-book"></i></span> <span>Livros</span></a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="level">
            <h1 class="title level-left">Livros</h1>
            <a href="{{url("/livros/create")}}" class="button is-info level-right">
                <span class="icon"><i class="fa fa-plus"></i></span> <span>Adicionar</span> </a>
        </div>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th class="is-1">#</th>
                <th>Titulo</th>
                <th class="is-1">Ação</th>
            </tr>
            </thead>
            <tbody>
            @forelse($livros as $livro)
                <tr>
                    <td>{{$livro->id}}</td>
                    <td>
                        <a href="{{url("/livros/{$livro->id}")}}">{{$livro->titulo}}</a>
                    </td>
                    <td>
                        <form action="{{url("/livros/{$livro->id}")}}" method="POST">
                            {!! method_field("DELETE") !!}
                            {!! csrf_field() !!}
                            <button class="button is-danger is-small remover">
                                <i class="fa fa-trash"></i>
                            </button>

                            <a href="{{url("/livros/{$livro->id}/edit")}}"
                               class="button is-info is-small"><i
                                        class="fa fa-pencil"></i></a>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="espaco">Nenhum Livro encontrado</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div>
            {!! $livros->render() !!}
        </div>
    </div>
@endsection
