const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'resources/vendor/fontawesome-free-5.12.1-web/css/all.min.css',
    'resources/vendor/sweetalert2/sweetalert2.css',
    'resources/css/adminlte.css',
    'resources/vendor/icheck-bootstrap/icheck-bootstrap.css',
    'resources/vendor/daterangepicker/daterangepicker.css',
    'resources/css/app.css'
],'public/css/app.css')
.js('resources/js/app.js', 'public/js')

.scripts([
    'resources/vendor/jquery/jquery.min.js',
    'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
    'resources/vendor/sweetalert2/sweetalert2.js',
    'resources/vendor/daterangepicker/moment.min.js',
    'resources/vendor/daterangepicker/daterangepicker.js',
], 'public/js/vendor.js')

.scripts([
    'resources/vendor/table-html-exel/table-html.js'
],'public/js/vendor/table-html/table-html.js')

.copy('resources/vendor/fontawesome-free-5.12.1-web/webfonts','public/webfonts')
.copy('resources/img','public/img')

.version();

mix.browserSync(process.env.APP_URL)
