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
                <a><span class="icon is-small"><i class="fa fa-book"></i></span> <span>Seções</span></a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="level">
            <h1 class="title level-left">Seções</h1>
            <a href="{{url("/secoes/create")}}" class="button is-info level-right">
                <span class="icon"><i class="fa fa-plus"></i></span> <span>Adicionar</span> </a>
        </div>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th class="is-1">#</th>
                <th>Descriçãoo</th>
                <th class="is-1">Ação</th>
            </tr>
            </thead>
            <tbody>
            @forelse($secoes as $secao)
                <tr>
                    <td>{{$secao->id}}</td>
                    <td>
                        <a href="{{url("/secoes/{$secao->id}")}}">{{$secao->descricao}}</a>
                    </td>
                    <td>
                        <form action="{{url("/secoes/{$secao->id}")}}" method="POST">
                            {!! method_field("DELETE") !!}
                            {!! csrf_field() !!}
                            <div class="level">
                                <a href="{{ url("/secoes/{$secao->id}/edit") }}" class="button is-info is-small level-left">
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
                    <td colspan="4" class="espaco">Nenhum Secao encontrado</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div>
            {!! $secoes->render() !!}
        </div>
    </div>
@endsection
