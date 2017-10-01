@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small"><i class="fa fa-home"></i></span>
                    <span>{{ config('app.name') }}</span> </a>
            </li>
            <li class="is-active">
                <a><span class="icon is-small"><i class="fa fa-book"></i></span> <span>Emprestimos</span></a>
            </li>
        </ul>
    </nav>

    <emprestimos-grid> </emprestimos-grid>
@endsection