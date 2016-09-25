<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Not Allowed - BGC Digital LTD</title>
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
    <body class="page-500-full-page">
        <div class="row">
            <div class="col-md-12 page-500">
                <div class="number font-red">500</div>
                <div class="details">
                    <h3>Oops! Something went wrong.</h3>
                    <p>We are fixing it! Please come back in a while.</p>
                </div>
            </div>
        </div>
    </body>
</html>
