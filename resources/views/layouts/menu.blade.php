<nav class="tabs is-boxed">
    <div class="container">
        <ul>
            <li{!! request()->is('emprestimos*')?' class="is-active"':'' !!}>
                <a href="/emprestimos">Empréstimos</a>
            </li>
            <li{!! request()->is('livros*')?' class="is-active"':'' !!}>
                <a href="/livros">Livros</a>
            </li>
            <li{!! request()->is('estudantes*')?' class="is-active"':'' !!}>
                <a href="/estudantes">Estudantes</a>
            </li>
            <li{!! request()->is('secoes*')?' class="is-active"':'' !!}>
                <a href="/secoes">Seções</a>
            </li>
            <li{!! request()->is('editoras*')?' class="is-active"':'' !!}>
                <a href="/editoras">Editoras</a>
            </li>

            <li{!! request()->is('info*')?' class="is-active"':'' !!}>
                <a href="/info">Info</a>
            </li>
        </ul>
    </div>
</nav>