@extends('layouts.app')

@section('content')
    <h1 class="title is-1">Informações</h1>
    <hr>
    <div class="box">
        <p class="title is-4">Funcionalidades a implementar</p>
        <ul>
            <li><s>Pesquisa por informações dos livros online através do ISBN</s></li>
            <li><s>Componentes para adição de seções, editoras e autores</s></li>
            <li><s>Telas de confirmação para ações, exemplo devolução</s></li>
            <li><s>Tela de Autenticação e regras de validação de acesso</s></li>
            <li>Tela de acesso para estudantes com permissão para renovação/reservas</li>
            <li><s>Relatórios de livros mais emprestados, menos emprestados e empréstimos com devolução atrasada</s></li>
        </ul>
    </div>
@endsection