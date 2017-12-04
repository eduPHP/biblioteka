@extends('layouts.app')
@section('content')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span>
                </a>
            </li>
            <li class="is-active">
                <a><span class="icon is-small"><i class="fa fa-file-pdf-o"></i></span> <span>Relatórios</span></a>
            </li>
            <li class="is-active">
                <a><span class="icon is-small"><i class="fa fa-book"></i></span> <span>Livros</span></a>
            </li>
        </ul>
    </nav>
    <relatorio-mais-emprestados></relatorio-mais-emprestados>
@endsection
