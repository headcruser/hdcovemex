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

// LIBRERIAS
mix.styles([
    'resources/vendor/fontawesome-free-5.12.1-web/css/all.min.css',
    'resources/vendor/sweetalert2/sweetalert2.css',
    'resources/css/adminlte.css',
    'resources/vendor/icheck-bootstrap/icheck-bootstrap.css',
    'resources/vendor/daterangepicker/daterangepicker.css',
    'resources/css/app.css'
],'public/css/app.css')
.js('resources/js/app.js', 'public/js');


mix.scripts([
    'resources/vendor/jquery/jquery.min.js',
    'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
    'resources/vendor/sweetalert2/sweetalert2.js',
    'resources/vendor/daterangepicker/moment.min.js',
    'resources/vendor/daterangepicker/daterangepicker.js',
], 'public/js/vendor.js');


mix.scripts([
    'resources/vendor/table-html-exel/table-html.js'
],'public/js/vendor/table-html/table-html.js')

.copy('resources/vendor/fontawesome-free-5.12.1-web/webfonts','public/webfonts')
.copy('resources/img','public/img');


// PIVOTTABLE LIB
mix.styles([
    'resources/vendor/pivottable_lib/c3.min.css',
], 'public/vendor/pivottable/pivot_lib.min.css')
.scripts([
    'resources/vendor/pivottable_lib/jquery_1.11.2.min.js',
    'resources/vendor/pivottable_lib/jquery-ui_1.11.4.min.js',
    'resources/vendor/pivottable_lib/d3.min.js',
    'resources/vendor/pivottable_lib/c3.min.js',
    'resources/vendor/pivottable_lib/jquery.ui.touch-punch.min.js'
], 'public/vendor/pivottable/pivot_lib.min.js');


mix.styles([
    'node_modules/pivottable/dist/pivot.min.css',
], 'public/vendor/pivottable/pivot.min.css')

.scripts([
    'node_modules/pivottable/dist/pivot.js',
    'node_modules/pivottable/dist/pivot.es.min.js',
    'node_modules/pivottable/dist/d3_renderers.js',
    'node_modules/pivottable/dist/c3_renderers.js',
    'node_modules/pivottable/dist/export_renderers.js',

], 'public/vendor/pivottable/pivot.min.js')
.version();

mix.browserSync(process.env.APP_URL)
