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
                padding    : 0;
            }

            .table tr td form .button, .table tr td:last-child .button {
                margin : 0.1rem;
            }

            .mr-1 {
                margin-right : 1em;
            }

            .ml-1 {
                margin-left : 1em;
            }

            .row{
                padding : 0 .8em;
            }

        </style>
    @show
</head>
<body>
<div id="app">

    <section class="hero is-info">
        <!-- Hero header: will stick at the top -->
        <div class="hero-head">
            <header class="nav">
                <div class="container">
                    <div class="nav-left">
                        <a class="nav-item title is-4" href="/">  {{ config('app.name') }} </a>
                    </div>
                    <span class="nav-toggle">
          <span></span>
          <span></span>
          <span></span>
        </span>
                    <div class="nav-right nav-menu">
                        <!-- Authentication Links -->
                        @guest
                            {{--<a class="nav-item" href="{{ route('login') }}">Login</a>--}}
                        @else
                            <div class="dropdown is-active">
                                <div class="dropdown-trigger">
                                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                        <span>{{ Auth::user()->name }}</span> <span class="icon is-small">
        <i class="fa fa-angle-down" aria-hidden="true"></i>
      </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> Logout </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </header>
        </div>

        <!-- Hero footer: will stick at the bottom -->
        <div class="hero-foot">
            @include('layouts.menu')
        </div>
    </section>
    <section class="section is-flex-1">
        <div class="container">
            {{--@include('partials.message')--}}
            @yield('content')
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <p>
                    <strong>{{config('app.name')}}</strong> by <a href="https://rdo.blog.br">Eduardo Dalla Vecchia</a>. The website content is licensed
                    <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
                </p>
                <p>
                    <a class="icon" href="https://github.com/swalker2"> <i class="fa fa-github"></i> </a>
                </p>
            </div>
        </div>
    </footer>

    <flash mensagem="{{ session('success') }}"></flash>
    <flash mensagem="{{ session('error') }}" tipo="erro"></flash>
</div>

<!-- Scripts -->
@section('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
@show
</body>
</html>
