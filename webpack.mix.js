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

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/home.js', 'public/js')
    // .js('resources/js/lib/jquery-ui.js', 'public/js')
   .styles('resources/css/lib/bootstrap-datepicker.css', 'public/css/bootstrap-datepicker.css')
   .sass('resources/sass/home.scss', 'public/css')
   .sass('node_modules/toastr/toastr.scss', 'public/css')
   .sass('resources/sass/app.scss', 'public/css');

mix.copy('resources/js/lib/bootstrap-datepicker.js', 'public/js/bootstrap-datepicker.js');
mix.copy('node_modules/moment/moment.js', 'public/js/moment.js');
mix.copy('node_modules/toastr/toastr.js', 'public/js/toastr.js');
// mix.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts/font-awesome');
