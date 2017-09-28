@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span> </a>
            </li>
            <li>
                <a href="{{ url('/livros') }}"> <span class="icon is-small"><i class="fa fa-book"></i></span> <span>Livros</span>
                </a>
            </li>
            <li class="is-active">
                <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Livro
            </li>
        </ul>
    </nav>
    <h1 class="title">Adicionar Livro</h1>
    <form action="{{ url('/livros') }}" method="POST" class="form-horizontal">
        {!! method_field("POST") !!}
        @include('livros.form')
    </form>
@endsection
