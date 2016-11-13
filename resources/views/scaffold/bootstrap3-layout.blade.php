<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Catamaran:300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <style>
        html, body {
            background-color: #f5f8fa;
            color: #636b6f;
            font-family: 'Catamaran', sans-serif;
            font-weight: 300;
            height: 100vh;
            margin: 0;
        }
        .wrapper {
            display: flex;
            height: 100vh;
            justify-content: center;
            position: relative;
        }
        .content {
            padding-top: 30px;
        }
        h1 {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ccc;
        }
        .links {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @if (Route::has('login'))
            <div class="links">
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            </div>
        @endif

        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    @yield('crud-styles')
    @yield('crud-scripts')
</body>
</html>
