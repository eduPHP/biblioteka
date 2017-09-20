@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">{{ config('app.name') }}</a></li>
                <li class="active">Estudantes</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Estudantes</div>

                <div class="panel-body">
                    <a href="{{url('/estudantes')}}" class="btn btn-info">Adicionar</a>

                </div>
                <div class="table-responsive">
                    <table class="table crud">
                        <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th>Nome</th>
                            <th class="col-md-1">Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($estudantes as $estudante)
                            <tr>
                                <td>{{$estudante->id}}</td>
                                <td>
                                    <a href="{{url("/estudantes/{$estudante->id}")}}">{{$estudante->nome}}</a>
                                </td>
                                <td>
                                    <form action="{{url("/estudantes/{$estudante->id}")}}" method="POST"
                                          class="form-horizontal">
                                        {!! method_field("DELETE") !!}
                                        {!! csrf_field() !!}
                                        <button type="submit" class="btn btn-danger remover"><i class="fa fa-trash"></i>
                                        </button>

                                        <a href="{{url("/estudantes/{$estudante->id}")}}"
                                           class="btn btn-info"><i
                                                    class="fa fa-pencil"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="espaco">Nenhum Estudante encontrado</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection