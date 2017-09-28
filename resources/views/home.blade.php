@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert is-success">
            {{ session('status') }}
        </div>
    @endif

    Você está <span class="is-success">logado</span>.
@endsection
