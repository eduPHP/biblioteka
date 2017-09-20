@extends('layouts.app')
@section('content')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">{{ config('app.name') }}</a></li>
                    <li><a href="{{ url('/estudantes') }}">Estudantes</a></li>
                    <li class="active">Editar</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Alterar Estudante {{$estudante->nome}}</div>

                    <div class="panel-body">
                        <form action="{{url("/estudantes/{$estudante->id}")}}" method="POST" class="form-horizontal">
                            {!! method_field("PATCH") !!}
                            @include('estudantes.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection