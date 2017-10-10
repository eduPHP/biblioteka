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
                <a><span class="icon is-small"><i class="fa fa-book"></i></span> <span>Editoras</span></a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="level">
            <h1 class="title level-left">Editoras</h1>
            <a href="{{url("/editoras/create")}}" class="button is-info level-right">
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
            @forelse($editoras as $editora)
                <tr>
                    <td>{{$editora->id}}</td>
                    <td>
                        <a href="{{url("/editoras/{$editora->id}")}}">{{$editora->nome}}</a>
                    </td>
                    <td>
                        <form action="{{url("/editoras/{$editora->id}")}}" method="POST">
                            {!! method_field("DELETE") !!}
                            {!! csrf_field() !!}
                            <div class="level">
                                <a href="{{ url("/editoras/{$editora->id}/edit") }}" class="button is-info is-small level-left">
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
                    <td colspan="4" class="espaco">Nenhum Editora encontrado</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div>
            {!! $editoras->render() !!}
        </div>
    </div>
@endsection
