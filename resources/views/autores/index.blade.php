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
                <a><span class="icon is-small"><i class="fa fa-book"></i></span> <span>Autores</span></a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="level">
            <h1 class="title level-left">Autores</h1>
            <a href="{{url("/autores/create")}}" class="button is-info level-right">
                <span class="icon"><i class="fa fa-plus"></i></span> <span>Adicionar</span> </a>
        </div>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th class="is-1">#</th>
                <th>Nome</th>
                <th class="is-1">Ação</th>
            </tr>
            </thead>
            <tbody>
            @forelse($autores as $autor)
                <tr>
                    <td>{{$autor->id}}</td>
                    <td>
                        <a href="{{url("/autores/{$autor->id}")}}">{{$autor->nome}}</a>
                    </td>
                    <td>
                        <form action="{{url("/autores/{$autor->id}")}}" method="POST">
                            {!! method_field("DELETE") !!}
                            {!! csrf_field() !!}
                            <div class="level">
                                <a href="{{ url("/autores/{$autor->id}/edit") }}" class="button is-info is-small level-left">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button class="button is-danger is-small remover level-right">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="espaco">Nenhum Autor encontrado</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div>
            {!! $autores->render() !!}
        </div>
    </div>
@endsection
