<a class="navbar-item{{request()->is('emprestimos*')?' is-active':''}}" href="/emprestimos"> Empréstimos </a>

<a class="navbar-item{{request()->is('acervo*')?' is-active':''}}" href="/acervo"> Acervo </a>

<a class="navbar-item{{request()->is('autores*')?' is-active':''}}" href="/autores"> Autores </a>

<a class="navbar-item{{request()->is('estudantes*')?' is-active':''}}" href="/estudantes"> Estudantes </a>

<a class="navbar-item{{request()->is('secoes*')?' is-active':''}}" href="/secoes"> Seções </a>

<a class="navbar-item{{request()->is('editoras*')?' is-active':''}}" href="/editoras"> Editoras </a>

<div class="navbar-item has-dropdown is-hoverable">
    <a class="navbar-link"> Relatórios </a>
    <div class="navbar-dropdown">
        <a href="/relatorios/mais-emprestados" class="navbar-item{{request()->is('relatorios/mais-emprestados*')?' is-active':''}}"> Livros mais emprestados </a>
    </div>
</div>