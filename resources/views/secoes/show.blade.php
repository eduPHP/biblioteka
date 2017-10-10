@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span> </a>
            </li>
            <li>
                <a href="{{ url('/secoes') }}"> <span class="icon is-small"><i class="fa fa-book"></i></span> <span>Seções</span>
                </a>
            </li>
            <li class="is-active">
                <span class="icon is-small"><i class="fa fa-plus"></i></span>Seção {{$secao->descricao}}
            </li>
        </ul>
    </nav>
    <h1 class="title">Seção {{$secao->descricao}}</h1>
    <p><strong>Descrição:</strong> {{$secao->descricao}}</p>
    <p><strong>Localização:</strong> {{$secao->localizacao}}</p>
@endsection
