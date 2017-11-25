@extends('layouts.app')

@section('content')
    <div class="tile has-text-centered is-ancestor">
        <div class="tile is-vertical is-8 is-6-desktop" style="margin: 2em auto">
            <div class="tile">
                <div class="tile is-parent is-vertical">
                    <article class="tile is-child notification is-success">
                            <p class="title is-3"><a href="/emprestimos">Empréstimos</a></p>
                            <figure class="image is-4by2">
                                <a href="/emprestimos"><img src="/images/emprestimos.jpg" alt="Empréstimos"></a>
                            </figure>
                    </article>
                    <article class="tile is-child notification is-info">
                        <p class="title is-3"><a href="/livros">Livros</a></p>
                        <figure class="image is-4by2">
                            <a href="/acervo"><img src="/images/livros.jpg" alt="Livros"></a>
                        </figure>
                    </article>
                </div>
                <div class="tile is-parent is-vertical">
                    <article class="tile is-child notification is-warning">
                        <p class="title is-3"><a href="/editoras">Editoras</a></p>
                        <figure class="image is-4by2">
                            <a href="/editoras"><img src="/images/editoras.jpg" alt="Editoras"></a>
                        </figure>
                    </article>
                    <article class="tile is-child notification is-danger">
                        <p class="title is-3"><a href="/secoes">Secoes</a></p>
                        <figure class="image is-4by2">
                            <a href="/secoes"><img src="/images/secoes.jpg" alt="Secoes"></a>
                        </figure>
                    </article>
                </div>
            </div>
        </div>
    </div>
@endsection