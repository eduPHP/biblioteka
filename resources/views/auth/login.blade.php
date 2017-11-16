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
        .card-header span{
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
            <span class="is-size-3 has-text-weight-semibold">{{config('app.name')}}</span>
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
                    <button type="submit" class="button is-info">
                        Login
                    </button>

                    <a class="button is-link" href="{{ route('password.request') }}"> Esqueceu sua senha? </a>
                </div>

            </div>
        </div>
    </div>
</form>

</body>
</html>