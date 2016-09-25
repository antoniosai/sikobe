<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>SIKOBE</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="Sulaeman" name="author" />

        <link rel="shortcut icon" href="{{ url('/favicon.png') }}" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ elixir('assets/css/global-plugin.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/css/theme.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/css/auth.css') }}">

        {{ \App\Support\Asset::scripts('header.scripts') }}
    </head>
    <body class="login">
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 login-container bs-reset">
                    @yield('content')

                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset"></div>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p>Copyright &copy; SIKOBE 2016</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bs-reset">
                    <div class="login-bg"> </div>
                </div>
            </div>
        </div>

        <!-- JavaScripts -->
        <!--[if lt IE 9]>
        <script src="{{ elixir('assets/js/ie.js') }}"></script>
        <![endif]-->

        {{ \App\Support\Asset::scripts('footer.scripts') }}

        <script src="{{ elixir('assets/js/global-plugin.js') }}"></script>
        <script src="{{ elixir('assets/js/auth-plugin.js') }}"></script>
        <script src="{{ url('/assets/js/app.min.js') }}"></script>
        <script src="{{ elixir('assets/js/auth.js') }}"></script>

        {{ \App\Support\Asset::js('footer.specific.js') }}
    </body>
</html>
