<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Not Found - BGC Digital LTD</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="Me" name="author" />

        <link rel="shortcut icon" href="{{ url('/favicon.png') }}" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

        <!-- Styles -->
        {{ \App\Support\Asset::css('header.top.specific.css') }}
        <link rel="stylesheet" href="{{ elixir('assets/css/global-plugin.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/css/theme.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/css/layout.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/css/error.css') }}">
        {{ \App\Support\Asset::css('header.specific.css') }}

        {{ \App\Support\Asset::scripts('header.scripts') }}
    </head>
    <body class="page-404-3">
        <div class="page-inner">
            <img src="{{ url('assets/img/earth.jpg') }}" class="img-responsive" alt="">
        </div>
        <div class="container error-404">
            <h1>404</h1>
            <h2>Maaf halaman yang Anda cari tidak di temukan.</h2>
        </div>
    </body>
</html>
