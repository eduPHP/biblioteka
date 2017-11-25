@extends('layouts.clean')
@section('title','Cadastro')
@section('content')
    <form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="card">
        <header class="card-header">
            <span class="is-size-3 has-text-weight-semibold">{{config('app.name')}}</span>
            <p>Cadastro</p>
        </header>
        <div class="card-content">
            <div class="content">
                <!-- Input Nome -->
                <div class="field">
                    <div class="control{{ $errors->has('nome') ? ' has-icons-right' : '' }}">
                        <input class="input{{ $errors->has('nome') ? ' is-danger' : '' }}"
                               name="nome" placeholder="Nome" value="{{ old('nome') }}">
                        {!! $errors->has('nome') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                    </div>
                    {!! $errors->first('nome', '<p class="help is-danger">:message</p>') !!}
                </div>


                <!-- Input Email -->
                <div class="field">
                    <div class="control{{ $errors->has('email') ? ' has-icons-right' : '' }}">
                        <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}"
                               name="email" placeholder="E-mail" value="{{old('email')}}">
                        {!! $errors->has('email') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                    </div>
                    {!! $errors->first('email', '<p class="help is-danger">:message</p>') !!}
                </div>

                <!-- Input Password -->
                <div class="field">
                    <div class="control{{ $errors->has('password') ? ' has-icons-right' : '' }}">
                        <input type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}"
                               name="password" placeholder="Senha">
                        {!! $errors->has('password') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                    </div>
                    {!! $errors->first('password', '<p class="help is-danger">:message</p>') !!}
                </div>
                <!-- Input Password Confirmation -->
                <div class="field">
                    <div class="control">
                        <input type="password" class="input"
                               name="password_confirmation" placeholder="Confirme sua senha">
                    </div>
                </div>

                <!-- Form Submit -->
                <div class="field is-grouped">
                    <button type="submit" class="button is-success is-fullwidth">
                        Cadastrar
                    </button>
                </div>
                <div class="field is-grouped is-marginless">
                    <a class="button is-link is-fullwidth is-small" href="{{ route('login') }}"> Já tem uma conta? </a>
                </div>

            </div>
        </div>
    </div>
    </form>
@endsection
@section('style')
    @parent
    <style>
        .card {
            max-width : 35rem;
        }

        .card-header span {
            margin : 1.3rem auto 0;
        }

        .card-header p {
            margin : 0 auto 1.3rem;
        }
    </style>
@stop