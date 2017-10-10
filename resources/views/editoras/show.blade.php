@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span> </a>
            </li>
            <li>
                <a href="{{ url('/editoras') }}"> <span class="icon is-small"><i class="fa fa-book"></i></span> <span>Editoras</span>
                </a>
            </li>
            <li class="is-active">
                <span class="icon is-small"><i class="fa fa-plus"></i></span>Editora {{$editora->nome}}
            </li>
        </ul>
    </nav>
    <h1 class="title">Editora {{$editora->nome}}</h1>
    <p><strong>Nome:</strong> {{$editora->nome}}</p>
@endsection
