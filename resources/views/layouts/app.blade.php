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
        <link rel="stylesheet" href="{{ elixir('assets/css/layout.css') }}">
        {{ \App\Support\Asset::css('header.specific.css') }}

        {{ \App\Support\Asset::scripts('header.scripts') }}
    </head>
    <body class="page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed page-md">
        <form id="form-logout" method="POST" action="{{ url('/logout') }}" style="display:none;">
            {{ csrf_field() }}
        </form>
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-static-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="javascript:;">
                        <img src="{{ url('assets/img/logo.png') }}" alt="logo" class="logo-default" />
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="{{ url('/assets/img/avatar.png') }}" />
                                <span class="username username-hide-on-mobile">{{ $user->name }}</span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{ url('/ctrl/me') }}">
                                        <i class="icon-user"></i> Profil
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:document.getElementById('form-logout').submit();"><i class="icon-key"></i> Keluar </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
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
        <div class="page-container">

            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <li class="nav-item{{ (Request::segment(1) == 'ctrl' && Request::segment(2) == 'dashboard') ? ' active open' : '' }}">
                            <a href="{{ url('/ctrl/dashboard') }}" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item{{ (Request::segment(1) == 'ctrl' && Request::segment(2) == 'areas') ? ' active open' : '' }}">
                            <a href="{{ url('/ctrl/areas') }}" class="nav-link nav-toggle">
                                <i class="icon-map"></i>
                                <span class="title">Area Terdampak</span>
                            </a>
                        </li>
                        <li class="nav-item{{ (Request::segment(1) == 'ctrl' && Request::segment(2) == 'information') ? ' active open' : '' }}">
                            <a href="{{ url('/ctrl/information') }}" class="nav-link nav-toggle">
                                <i class="icon-info"></i>
                                <span class="title">Informasi</span>
                            </a>
                        </li>
                        @if ($user->isSuperAdmin())
                        <li class="heading">
                            <h3 class="uppercase">Administrasi</h3>
                        </li>
                        <li class="nav-item{{ (Request::segment(1) == 'ctrl' && Request::segment(2) == 'posko') ? ' active open' : '' }}">
                            <a href="{{ url('/ctrl/posko') }}" class="nav-link nav-toggle">
                                <i class="icon-shield"></i>
                                <span class="title">Posko</span>
                            </a>
                        </li>
                        <li class="nav-item{{ (Request::segment(1) == 'ctrl' && Request::segment(2) == 'users') ? ' active open' : '' }}">
                            <a href="{{ url('/ctrl/users') }}" class="nav-link nav-toggle">
                                <i class="icon-users"></i>
                                <span class="title">Pengguna</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                    <!-- END SIDEBAR MENU -->
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
        </div>

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
            <div class="page-footer-inner"> 2016 &copy; SIKOBE by <a href="https://github.com/feelinc/sikobe" target="_blank">RELAWAN TIK</a>.
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->

        <!-- JavaScripts -->
        <!--[if lt IE 9]>
        <script src="{{ elixir('assets/js/ie.js') }}"></script>
        <![endif]-->

        {{ \App\Support\Asset::scripts('footer.scripts') }}

        <script src="{{ elixir('assets/js/global-plugin.js') }}"></script>
        <script src="{{ url('/assets/js/app.min.js') }}"></script>
        <script src="{{ elixir('assets/js/ui.js') }}"></script>
        <script src="{{ elixir('assets/js/layout.js') }}"></script>

        {{ \App\Support\Asset::js('footer.specific.js') }}
    </body>
</html>
