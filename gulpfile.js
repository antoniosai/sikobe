const elixir = require('laravel-elixir');

// require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        '../plugins/font-awesome/css/font-awesome.css',
        '../plugins/simple-line-icons/simple-line-icons.css',
        '../plugins/bootstrap/css/bootstrap.min.css',
        '../plugins/uniform/css/uniform.default.css',
        '../plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        '../plugins/bootstrap-toastr/toastr.min.css'
    ], 'public/assets/css/global-plugin.css');
});

elixir(function(mix) {
    mix.sass([
        'global/components-md.scss',
        'global/plugins-md.scss'
    ], 'public/assets/css/theme.css');
});

elixir(function(mix) {
    mix.sass([
        'layouts/layout/layout.scss',
        'layouts/layout/themes/light2.scss',
        'layouts/layout/custom.scss'
    ], 'public/assets/css/layout.css');
});

elixir(function(mix) {
    mix.sass([
        'layouts/layout/layout.scss',
        'layouts/layout/themes/blue.scss',
        'pages/contact.scss',
        'pages/about.scss',
        'layouts/layout/front-custom.scss'
    ], 'public/assets/css/front-layout.css');
});

elixir(function(mix) {
    mix.sass([
        'pages/error.scss'
    ], 'public/assets/css/error.css');
});

elixir(function(mix) {
    mix.sass([
        'pages/login-5.scss'
    ], 'public/assets/css/auth.css');
});

elixir(function(mix) {
    mix.sass([
        'pages/profile.scss'
    ], 'public/assets/css/profile.css');
});

elixir(function(mix) {
    mix.sass([
        '../plugins/pace/themes/pace-theme-flash.css',
        'apps/todo.scss',
        'apps/todo-2.scss',
        'pages/search.scss',
        '../plugins/cubeportfolio/css/cubeportfolio.css'
    ], 'public/assets/css/home.css');
});

elixir(function(mix) {
    mix.scripts([
        '../plugins/respond.min.js',
        '../plugins/excanvas.min.js'
    ], 'public/assets/js/ie.js');
});

elixir(function(mix) {
    mix.scripts([
        '../plugins/jquery.min.js',
        '../plugins/bootstrap/js/bootstrap.min.js',
        '../plugins/js.cookie.min.js',
        '../plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        '../plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        '../plugins/jquery.blockui.min.js',
        '../plugins/uniform/jquery.uniform.min.js',
        '../plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        '../plugins/bootstrap-toastr/toastr.min.js'
    ], 'public/assets/js/global-plugin.js');
});

elixir(function(mix) {
    mix.scripts([
        '../plugins/bootstrap-confirmation/bootstrap-confirmation.min.js'
    ], 'public/assets/js/ui.js');
});

elixir(function(mix) {
    mix.scripts([
        '../js/layout.js',
        '../js/quick-sidebar.js'
    ], 'public/assets/js/layout.js');
});

elixir(function(mix) {
    mix.scripts([
        '../plugins/jquery-validation/js/jquery.validate.min.js',
        '../plugins/jquery-validation/js/additional-methods.min.js',
        '../plugins/backstretch/jquery.backstretch.min.js'
    ], 'public/assets/js/auth-plugin.js');
});

elixir(function(mix) {
    mix.scripts([
        '../js/login.js'
    ], 'public/assets/js/auth.js');
});

elixir(function(mix) {
    mix.scripts([
        '../plugins/pace/pace.min.js',
        '../plugins/cubeportfolio/js/jquery.cubeportfolio.min.js'
    ], 'public/assets/js/home.js');
});

elixir(function(mix) {
    mix.scripts([
        '../js/file-upload.js'
    ], 'public/assets/js/file-upload.js');
});

elixir(function(mix) {
    mix.version([
        'assets/css/global-plugin.css',
        'assets/css/theme.css',
        'assets/css/layout.css',
        'assets/css/front-layout.css',
        'assets/css/auth.css',
        'assets/css/profile.css',
        'assets/css/home.css',
        'assets/css/error.css',
        'assets/js/ie.js',
        'assets/js/global-plugin.js',
        'assets/js/ui.js',
        'assets/js/layout.js',
        'assets/js/auth-plugin.js',
        'assets/js/auth.js',
        'assets/js/home.js',
        'assets/js/file-upload.js'
    ]);
});
