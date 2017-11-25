<!doctype html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} @yield('title')</title>
    @section('style')
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <style>
            body, html {
                height : auto;
            }

            .card {
                max-width : 25rem;
                margin    : 5rem auto;
            }

            .card-header {
                flex-direction : column;
                align-items    : center;
            }

            .card-header h1 {
                margin : 2rem auto;
            }

            .field.is-grouped {
                justify-content : center;
            }
        </style>
    @show
</head>
<body>
 <div id="app">
     @yield('content')
 </div>
<script src="{{ mix('js/app.js') }}" type="application/javascript"></script>
</body>
</html>