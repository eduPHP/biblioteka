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
            <h1 class="title level-left">Livros mais emprestados</h1>
        </div>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th class="is-2">Empréstimos</th>
                <th>Titulo</th>
            </tr>
            </thead>
            <tbody>
            @forelse($livros as $livro)
                <tr>
                    <td>{{$livro->emprestimos_count}}</td>
                    <td>
                        <a href="{{url("/livros/{$livro->id}")}}">{{$livro->titulo}}</a>
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
