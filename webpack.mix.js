let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');


// mix.styles([
//     'resources/assets/bower_components/bootstrap/dist/css/bootstrap.min.css',
//     'resources/assets/bower_components/font-awesome/css/font-awesome.min.css',
//     'resources/assets/bower_components/Ionicons/css/ionicons.min.css',
//     'resources/assets/dist/css/AdminLTE.min.css',
//     'resources/assets/dist/css/skins/_all-skins.min.css'
//
//
// ], 'public/css/libs.css');
//
// mix.scripts([
//     'resources/assets/bower_components/bootstrap/dist/js/bootstrap.min.js',
//     'resources/assets/bower_components/fastclick/lib/fastclick.js',
//     'resources/assets/dist/js/adminlte.min.js',
//     'resources/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
//     'resources/assets/dist/js/pages/dashboard2.js'
//
//
// ], 'public/js/libs.js');