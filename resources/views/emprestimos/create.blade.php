@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small">
                        <i class="fa fa-home"></i></span><span>{{ config('app.name') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/emprestimos') }}">
                    <span class="icon is-small"><i class="fa fa-book"></i></span> <span>Emprestimos</span>
                </a>
            </li>
            <li class="is-active">
                <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Emprestimo
            </li>
        </ul>
    </nav>
    <h1 class="title">Adicionar Emprestimo</h1>
    <hr />
    <criar-emprestimo></criar-emprestimo>

@endsection
