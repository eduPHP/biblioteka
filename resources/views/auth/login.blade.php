<!doctype html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
            margin: 0 auto;
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
            <span class="is-size-3 has-text-weight-semibold">Login</span>
        </header>
        <div class="card-content">
            <div class="content">
                <!-- Input Email -->
                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control{{ $errors->has('email') ? ' has-icons-right' : '' }}">
                        <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}"
                               name="email" id="email" value="{{old('email')}}">
                        {!! $errors->has('email') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                    </div>
                    {!! $errors->first('email', '<p class="help is-danger">:message</p>') !!}
                </div>

                <!-- Input Password -->
                <div class="field">
                    <label class="label" for="password">Password</label>
                    <div class="control{{ $errors->has('password') ? ' has-icons-right' : '' }}">
                        <input type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}"
                               name="password" id="password" value="{{old('password')}}">
                        {!! $errors->has('password') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                    </div>
                    {!! $errors->first('password', '<p class="help is-danger">:message</p>') !!}
                </div>
                <!-- Checkbox Remember ${FOLDER} -->
                <div class="field">
                    <input class="is-checkbox" id="remember" type="checkbox" name="remember"
                            {{ old('remember') ? 'checked' : '' }}> <label for="remember"> Remember me </label>
                </div>
                <!-- Form Submit -->
                <div class="field is-grouped">
                    <button type="submit" class="button is-info">
                        Login
                    </button>

                    <a class="button is-link" href="{{ route('password.request') }}"> Forgot Your Password? </a>
                </div>

            </div>
        </div>
    </div>
</form>

</body>
</html>