var elixir = require('laravel-elixir');

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
    mix
    .sass(
        [
            'app.scss',
            'new_product_page.scss'
            // 'cart.scss'
        ],
        'resources/assets/css/dist'
    )
    .styles(
        [   // Source
        // 	'libs/bootstrap.min.css', // loading as cdn
            // 'libs/owl.carousel.css',
            'style.css',
            'libs/responsive.css',
            'libs/fonts.css',
            'libs/magnific-popup.css',
            // 'libs/font-awesome.css', // loading as cdn
            'libs/sweetalert.css',
            'dist/**/*.css'
        ],
        'public/css')
    .scripts(
        [   // Source
        // 	'libs/jquery.min.js', // loading as cdn
        // 	'libs/bootstrap.min.js', // loading as cdn
        // 	'libs/modernizr-2.7.1.min.js',
            'libs/jquery.touch.min.js',
        	'libs/jPushMenu.js',
        // 	'libs/owl.carousel.min.js',
            // 'bootstrap-hover-dropdown.js',
            'libs/jquery.cookie.js',
        	'libs/placeholder.js',
            'libs/sweetalert.min.js',
            'libs/jquery.magnific-popup.min.js',
        	'general.js'
    	],
    	'public/js' // Destination
    )
    .scripts(
        ['libs/instafeed.js'],
        'public/js/instafeed.js'
    )
    .copy(
        [
            'resources/assets/js/**/*.js',
        ],
        'public/js'
    )
    .browserSync({
        proxy: 'http://devgru.flavorgod.com',
        // port: 1337
    });
});
