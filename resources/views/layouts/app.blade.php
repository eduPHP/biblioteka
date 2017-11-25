<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    @section('style')
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <style>
            .table.crud th:last-child {
                width      : 5rem;
                text-align : center;
            }

            .table td.has-buttons {
                padding : 0;
            }

            .table tr td form .button, .table tr td:last-child .button {
                margin : 0.1rem;
            }

            .mr-1 {
                margin-right : 1em;
            }

            .mr-2 {
                margin-right : 2em;
            }

            .is-borderless {
                border  : none;
                outline : none;
            }

            .blended-input {
                font-size   : 1rem;
                height      : 2.23em;
                line-height : 1.4;
                background  : transparent;
            }

            .input > .tag > i {
                margin-right : .3rem;
            }

            .ml-1 {
                margin-left : 1em;
            }

            .pt-1 {
                padding-top : 1em;
            }

            .row {
                padding : 0 .8em;
            }

            .flex-1 {
                flex : 1;
            }
            .navbar-item.titulo{
                font-size   : 1.5rem;
                font-weight : 600;
            }
        </style>
    @show
</head>
<body>
<div id="app">
    <header>
        <nav class="navbar is-info">
            <div class="navbar-brand">
                <a class="navbar-item titulo" href="/">  {{ config('app.name') }} </a>

            <div class="navbar-burger burger" :class="{'is-active': menuOpen}" @click="menuOpen = !menuOpen">
                <span></span> <span></span> <span></span>
            </div>
        </div>

        <div class="navbar-menu" :class="{'is-active': menuOpen}">
            <div class="navbar-start">

                @include('layouts.menu')

            </div>

            <div class="navbar-end">
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
                </div>
            </div>
        </nav>
    </header>
    <section class="section is-flex-1">
        <div class="container">
            @yield('content')
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <p>
                    <strong>{{config('app.name')}}</strong> by <a href="https://rdo.blog.br">Eduardo Dalla Vecchia</a>.
                                                            The website content is licensed
                    <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
                </p>
                <p>
                    <a class="icon" href="https://github.com/swalker2"> <i class="fa fa-github"></i> </a>
                </p>
            </div>
        </div>
    </footer>

    @if(session('error'))
        <flash mensagem="{{ session('error') }}" tipo="erro"></flash>
    @else
        <flash mensagem="{{ session('success') }}"></flash>
    @endif
</div>

<!-- Scripts -->
@section('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
@show
</body>
</html>
