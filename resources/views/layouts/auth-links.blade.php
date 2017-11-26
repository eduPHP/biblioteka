<!-- Authentication Links -->
@guest
    <a class="navbar-item" href="/register">Cadastre-se</a>
    <a class="navbar-item" href="/login">Login</a>
@else
    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link"> {{ auth()->user()->nome }} </a>
        <div class="navbar-dropdown is-right">
            <a class="navbar-item" @click="logout"> Logout </a>
            <hr class="navbar-divider">
            <a href="/info" class="navbar-item"> Versão 0.6.1 </a>
        </div>
    </div>
@endguest