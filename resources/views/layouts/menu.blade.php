@can('view',\App\Emprestimo::class)
    <a class="navbar-item{{request()->is('emprestimos*')?' is-active':''}}" href="/emprestimos"> Empréstimos </a>
@endcan
@can('view',\App\Livro::class)
    <a class="navbar-item{{request()->is('acervo*')?' is-active':''}}" href="/acervo"> Acervo </a>
@endcan
@can('view',\App\Autor::class)

    <a class="navbar-item{{request()->is('autores*')?' is-active':''}}" href="/autores"> Autores </a>
@endcan
@can('view',\App\Estudante::class)

    <a class="navbar-item{{request()->is('estudantes*')?' is-active':''}}" href="/estudantes"> Estudantes </a>
@endcan
@can('view',\App\Secao::class)

    <a class="navbar-item{{request()->is('secoes*')?' is-active':''}}" href="/secoes"> Seções </a>
@endcan
@can('view',\App\Editora::class)
    <a class="navbar-item{{request()->is('editoras*')?' is-active':''}}" href="/editoras"> Editoras </a>
@endcan
@can('view-relatorios', auth()->user())
    <div class="navbar-item has-dropdown is-hoverable{{request()->is('relatorios*')?' is-active-styled':''}}">
        <a class="navbar-link"> Relatórios </a>
        <div class="navbar-dropdown">
            <a href="/relatorios/mais-emprestados" class="navbar-item{{request()->is('relatorios/mais-emprestados*')?' is-active':''}}"> Livros mais emprestados </a>
        </div>
    </div>
@endcan
