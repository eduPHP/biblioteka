@extends('layouts.clean')
@section('title','Login')
@section('content')
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="card">
            <header class="card-header">
                <h1 class="is-size-3 has-text-weight-semibold">{{config('app.name')}}</h1>
                <p>Forneça suas credenciais para realizar login.</p>
            </header>
            <div class="card-content">
                <div class="content">
                    <!-- Input Email -->
                    <div class="field">
                        <div class="control{{ $errors->has('email') ? ' has-icons-right' : '' }}">
                            <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}"
                                   name="email" placeholder="Digite seu e-mail" value="{{old('email')}}">
                            {!! $errors->has('email') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                        </div>
                        {!! $errors->first('email', '<p class="help is-danger">:message</p>') !!}
                    </div>

                    <!-- Input Password -->
                    <div class="field">
                        <div class="control{{ $errors->has('password') ? ' has-icons-right' : '' }}">
                            <input type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}"
                                   name="password" placeholder="Digite sua senha" value="{{old('password')}}">
                            {!! $errors->has('password') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                        </div>
                        {!! $errors->first('password', '<p class="help is-danger">:message</p>') !!}
                    </div>
                    <!-- Checkbox Remember -->
                    <div class="field">
                        <input class="is-checkbox" id="remember" type="checkbox" name="remember"
                                {{ old('remember') ? 'checked' : '' }}> <label for="remember"> Lembre-me </label>
                    </div>
                    <!-- Form Submit -->
                    <div class="field is-grouped">
                        <button type="submit" class="button is-success is-fullwidth">
                            Login
                        </button>
                    </div>
                    <div class="field is-grouped is-marginless">
                        <a class="button is-link is-small" href="/password/reset"> Esqueceu sua senha? </a>
                    </div>
                    <div class="field is-grouped is-marginless">
                        <a class="button is-link is-small" href="/register"> Não tem cadastro? </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection