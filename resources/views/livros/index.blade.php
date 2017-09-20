@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">{{ config('app.name') }}</a></li>
                <li class="active">Livros</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Livros</div>

                <div class="panel-body">
                    <a href="{{url('/livros')}}" class="btn btn-info">Adicionar</a>

                </div>
                <div class="table-responsive">
                    <table class="table crud">
                        <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th>Titulo</th>
                            <th class="col-md-1">Ação</th>
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
                                    <form action="{{url("/livros/{$livro->id}")}}" method="POST"
                                          class="form-horizontal">
                                        {!! method_field("DELETE") !!}
                                        {!! csrf_field() !!}
                                        <button type="submit" class="btn btn-danger remover"><i class="fa fa-trash"></i>
                                        </button>

                                        <a href="{{url("/livros/{$livro->id}")}}"
                                           class="btn btn-info"><i
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
                </div>
            </div>
        </div>
    </div>
@endsection