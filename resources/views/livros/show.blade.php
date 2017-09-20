@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></li>
                <li><a href="{{ url('/livros') }}">Livros</a></li>
                <li class="active">{{$livro->titulo}}</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Livro {{$livro->titulo}}</div>

                <div class="panel-body">
                    <div class="list-group">
                        <p><strong>ISBN:</strong> {{$livro->isbn}}</p>
                        <p><strong>Titulo:</strong> {{$livro->titulo}}</p>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection