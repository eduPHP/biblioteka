@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span> </a>
            </li>
            <li class="is-active">
                <a><span class="icon is-small"><i class="fa fa-book"></i></span> <span>Emprestimos</span></a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="level">
            <h1 class="title level-left">Emprestimos</h1>
            <a href="{{url("/emprestimos/create")}}" class="button is-info level-right">
                <span class="icon"><i class="fa fa-plus"></i></span> <span>Adicionar</span> </a>
        </div>

        <emprestimos-grid> </emprestimos-grid>



        {{--<table class="table is-fullwidth">--}}
            {{--<thead>--}}
            {{--<tr>--}}
                {{--<th>#</th>--}}
                {{--<th>Livro</th>--}}
                {{--<th>Estudante</th>--}}
                {{--<th>Entrega</th>--}}
                {{--<th v-if="mostraBotoes">Ação</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@forelse($emprestimos as $emprestimo)--}}
                    {{--<tr>--}}
                        {{--<td>{{$emprestimo->id}}</td>--}}
                        {{--<td>--}}
                            {{--<a href="{{url("/livros/{$emprestimo->livro->id}")}}">{{$emprestimo->livro->titulo}}</a>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<a href="{{url("/estudantes/{$emprestimo->estudante->id}")}}">{{$emprestimo->estudante->nome}}</a>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--{{ $emprestimo->devolvido?'Devolvido':ucfirst($emprestimo->devolucao->diffForHumans()) }}--}}
                        {{--</td>--}}
                        {{--<td v-if="mostraBotoes">--}}
                            {{--<a @click="renovar({{ $emprestimo->id }})" title="Renovar" class="button is-info is-small">--}}
                                {{--<i class="fa fa-recycle"></i> </a>--}}
                            {{--<a @click="devolver({{ $emprestimo->id }})" title="Devolver" class="button is-danger is-small">--}}
                                {{--<i class="fa fa-arrow-circle-o-down"></i> </a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
            {{--@empty--}}
                {{--<tr>--}}
                    {{--<td colspan="4" class="espaco">Nenhum Emprestimo encontrado</td>--}}
                {{--</tr>--}}
            {{--@endforelse--}}
            {{--</tbody>--}}
        {{--</table>--}}
        {{--<div>--}}
            {{--{!! $emprestimos->render() !!}--}}
        {{--</div>--}}
    </div>
@endsection