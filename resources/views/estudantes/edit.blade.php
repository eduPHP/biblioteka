@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span> </a>
            </li>
            <li>
                <a href="{{ url('/estudantes') }}"> <span class="icon is-small"><i class="fa fa-book"></i></span> <span>Estudantes</span>
                </a>
            </li>
            <li class="is-active">
                <span class="icon is-small"><i class="fa fa-plus"></i></span> Editar Estudante {{$estudante->nome}}
            </li>
        </ul>
    </nav>
    <h1 class="title">Editar Estudante {{$estudante->nome}}</h1>
    <form action="{{ url("/estudantes/{$estudante->id}") }}" method="POST" class="form-horizontal">
        {!! method_field("PATCH") !!}
        @include('estudantes.form')
    </form>
@endsection
