@extends('layouts.clean')
@section('title','Permissão negada!')
@section('content')
    <div class="card">
        <header class="card-header">
            <h1 class="is-size-3 has-text-weight-semibold">Erro!</h1>
        </header>
        <div class="card-content">
            <div class="content has-text-centered">
                <p>Você não tem permissões para acessar este conteúdo!</p>
                <button class="button is-link" @click="voltar">Voltar</button>
            </div>

        </div>
    </div>
@endsection
