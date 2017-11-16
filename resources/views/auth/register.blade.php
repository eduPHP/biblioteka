<!doctype html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} Cadastro</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        body, html{
            height: auto;
        }
        .card {
            max-width : 35rem;
            margin    : 5rem auto;
        }
        .card-header{
            flex-direction : column;
        }
        .card-header span{
            margin: 1.3rem auto 0;
        }
        .card-header p{
            margin: 0 auto 1.3rem;
        }
        .field.is-grouped{
            justify-content: center;
        }
    </style>
</head>
<body>
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
                    <button type="submit" class="button is-info">
                        Cadastrar
                    </button>
                    <a class="button is-link" href="{{ route('login') }}"> Já tem uma conta? </a>
                </div>

            </div>
        </div>
    </div>
</form>

</body>
</html>