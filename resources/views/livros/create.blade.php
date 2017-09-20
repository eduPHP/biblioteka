@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">{{ config('app.name') }}</a></li>
                <li><a href="{{ url('/livros') }}">Livros</a></li>
                <li class="active">Adicionar</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Adicionar Livro</div>

                <div class="panel-body">
                    <form action="{{ url('/livros') }}" method="POST" class="form-horizontal">
                        {!! method_field("POST") !!}
                        @include('livros.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection