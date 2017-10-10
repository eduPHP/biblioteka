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
                <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Seção
            </li>
        </ul>
    </nav>
    <h1 class="title">Adicionar Seção</h1>
    <form action="{{ url('/secoes') }}" method="POST" class="form-horizontal">
        {!! method_field("POST") !!}
        @include('secoes.form')
    </form>
@endsection
