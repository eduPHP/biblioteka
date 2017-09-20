@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></li>
                <li><a href="{{ url('/estudantes') }}">Estudantes</a></li>
                <li class="active">{{$estudante->nome}}</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Estudante {{$estudante->nome}}</div>

                <div class="panel-body">
                    <div class="list-group">
                        <p><strong>Nome:</strong> {{$estudante->nome}}</p>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection