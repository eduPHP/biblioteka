<!doctype html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} Login</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        body, html{
            height: auto;
        }
        .card {
            max-width : 25rem;
            margin    : 5rem auto;
        }
        .card-header{
            flex-direction : column;
            align-items    : center;
        }
        .card-header h1{
            margin: 2rem auto;
        }
        .field.is-grouped{
            justify-content: center;
        }
    </style>
</head>
<body>
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

</body>
</html>