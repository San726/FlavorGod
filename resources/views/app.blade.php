<!doctype html>
<!--[if IE]>
<html class="ie" lang="en-US">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en-US">
<!--><![endif]-->
    <head>
        <!-- Google Tag Manager -->
        <!--
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M3XCSC"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M3XCSC');</script>
         -->
        <meta charset="utf-8">
        <meta name="google-site-verification" content="eI1-byOMOMI3Ok6r_xRZZao-3F9aQG80dKjjv-FSEsE" />
        <meta name="msvalidate.01" content="70295A5F204DD7C57A5D5436FF3E75ED" />
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="keywords" content="@section('keywords'){{@$keywords}}@show">
        <meta name="description" content="@section('description'){{@$description}}@show">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- FAVICON START -->
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('images/favicon/apple-touch-icon-57x57.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/favicon/apple-touch-icon-114x114.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/favicon/apple-touch-icon-72x72.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/favicon/apple-touch-icon-144x144.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('images/favicon/apple-touch-icon-60x60.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('images/favicon/apple-touch-icon-120x120.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('images/favicon/apple-touch-icon-76x76.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-196x196.png') }}" sizes="196x196" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-96x96.png') }}" sizes="96x96" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-32x32.png') }}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-16x16.png') }}" sizes="16x16" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-128.png') }}" sizes="128x128" />
        <meta name="application-name" content="Flavor God"/>
        <meta name="msapplication-TileColor" content="#FFFFFF" />
        <meta name="msapplication-TileImage" content="{{ asset('images/favicon/mstile-144x144.png') }}" />
        <meta name="msapplication-square70x70logo" content="{{ asset('images/favicon/mstile-70x70.png') }}" />
        <meta name="msapplication-square150x150logo" content="{{ asset('images/favicon/mstile-150x150.png') }}" />
        <meta name="msapplication-wide310x150logo" content="{{ asset('images/favicon/mstile-310x150.png') }}" />
        <meta name="msapplication-square310x310logo" content="{{ asset('images/favicon/mstile-310x310.png') }}" />
        <link rel="shortcut icon" type="/image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
        <!-- FAVICON END -->

        @yield('metas')
        @if(App::environment('production'))
        <title>FLAVOR GOD | @yield('title')</title>
        @else
        <title>{{ strtoupper(App::environment()) }} - FLAVOR GOD | @yield('title')</title>
        @endif
        <!--[if lte IE 8]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:700,300italic%7cSource+Sans+Pro:400,200,300,600,700,900,600italic,700italic%7cLato:100,300,400,700,900%7cPT+Sans:400,700,400italic,700italic%7cMontserrat:400,700">
        @yield('fonts')
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/all.css') }}">
        @yield('styles')
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
        @yield('top-scripts')
        @include('includes.binganalytics')
        @include('includes.googleanalytics')
    </head>

    <body class="@yield('bodyClass')">
        @include('includes.googletagmanager')
        @include('includes.header')
        @yield('pre-content')
        @yield('content')
        @yield('post-content')
        @include('includes.footer')
        <div class="preloader">
            <img src="/images/icon-cart-hover.png" alt="">
        </div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.ui.min.js"></script>
        @yield('lib-scripts')
        <script src="{{ asset('js/all.js') }}" type="text/javascript"></script>
        @yield('scripts')
        @yield('profileedit.script');
        @yield('addressedit.script');
        @if(isset($alert))
        <script>
        	(function(){
        		swal({
                  title: "{{ @$alert['title'] }}",
                  text: "{{ @$alert['message'] }}",
                  type: "{{ @$alert['type'] }}",
                  confirmButtonText: "{{ @$alert['button'] }}",
                  showConfirmButton: "{{ @$alert['showConfirmButton']}}",
                  timer: "{{ @$alert['timer'] }}"
        		});
        	})();
        </script>
        @endif
        @include('components.user-authentication')
        @yield('modals')

        @if(App::environment('production'))
        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
        $.src="//v2.zopim.com/?2ouccdgzUetHYxnL435hhDTOtDyPiYrV";z.t=+new Date;$.
        type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
        </script>

        @include('includes.analytics')

        @endif
    </body>
</html>
