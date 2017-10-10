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
                <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Editora
            </li>
        </ul>
    </nav>
    <h1 class="title">Adicionar Editora</h1>
    <form action="{{ url('/editoras') }}" method="POST" class="form-horizontal">
        {!! method_field("POST") !!}
        @include('editoras.form')
    </form>
@endsection
