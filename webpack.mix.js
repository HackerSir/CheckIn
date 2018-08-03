const {mix} = require('laravel-mix');

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
let buildPath = 'public/build-js';

mix.js('resources/assets/js/vue.js', buildPath)
    .js('resources/assets/js/checkin.js', buildPath)
    .js('resources/assets/js/broadcast-test.js', buildPath)
    .version();
