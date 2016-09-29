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
        {{ \App\Support\Asset::css('header.top.specific.css') }}
        <link rel="stylesheet" href="{{ elixir('assets/css/global-plugin.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/css/theme.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/css/front-layout.css') }}">
        {{ \App\Support\Asset::css('header.specific.css') }}

        {{ \App\Support\Asset::scripts('header.scripts') }}
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-sidebar-closed page-md">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="javascript:;">
                        <img src="{{ url('assets/img/logo.png') }}" alt="logo" class="logo-default" />
                    </a>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown">
                            <a href="{{ url('/') }}" class="dropdown-toggle">
                                <i class="icon-home"></i> <span class="hidden-xs">Beranda</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('/informations') }}" class="dropdown-toggle">
                                <i class="icon-feed"></i> <span class="hidden-xs">Informasi</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('/incidents') }}" class="dropdown-toggle">
                                <i class="icon-fire"></i> <span class="hidden-xs">Kejadian</span>
                            </a>
                        </li>
                        <!--<li class="dropdown">
                            <a href="{{ url('/needs') }}" class="dropdown-toggle">
                                <i class="icon-heart"></i> <span class="hidden-xs">Daftar Kebutuhan</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('/new-incident') }}" class="dropdown-toggle">
                                <i class="icon-flag"></i> <span class="hidden-xs">Laporkan Kejadian</span>
                            </a>
                        </li>-->
                        <li class="dropdown">
                            <a href="{{ url('/contact') }}" class="dropdown-toggle">
                                <i class="icon-envelope"></i> <span class="hidden-xs">Kirim Pesan</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->

        <!-- BEGIN CONTAINER -->
        <div class="page-container"></div>

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                @yield('content')
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->

        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2016 &copy; SIKOBE by <a href="https://github.com/feelinc/sikobe" class="font-white" target="_blank">RELAWAN TIK</a>.</div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->

        <!-- JavaScripts -->
        <!--[if lt IE 9]>
        <script src="{{ elixir('assets/js/ie.js') }}"></script>
        <![endif]-->

        <script src="{{ url('/assets/js/api.js') }}"></script>

        {{ \App\Support\Asset::scripts('footer.scripts') }}

        <script src="{{ elixir('assets/js/global-plugin.js') }}"></script>
        <script src="{{ url('/assets/js/app.min.js') }}"></script>
        <script src="{{ elixir('assets/js/ui.js') }}"></script>
        <script src="{{ elixir('assets/js/layout.js') }}"></script>

        {{ \App\Support\Asset::js('footer.specific.js') }}

        @if (! app()->environment('local'))
        <!-- Google Analytic -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-84943613-1', 'auto');
          ga('send', 'pageview');
        </script>
        @endif
    </body>
</html>
