<!doctype html>
<!--[if IE]>
<html class="ie" lang="en-US">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en-US">
<!--><![endif]-->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="@section('keywords'){{@$keywords}}@show">
    <meta name="description" content="@section('description'){{@$description}}@show">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('metas')
    @if(App::environment('production'))
    <title>FLAVOR GOD | @yield('title')</title>
    @else
    <title>{{ strtoupper(App::environment()) }} - FLAVOR GOD | @yield('title')</title>
    @endif
    <!--[if lte IE 8]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="/image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:700,300italic%7cSource+Sans+Pro:400,200,300,600,700,900,600italic,700italic%7cLato:100,300,400,700,900%7cPT+Sans:400,700,400italic,700italic">
    @yield('fonts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("css/paypal.css") }}">
    @yield("styles")
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    @yield("top-scripts")
    @include('includes.googleanalytics')
    @include('includes.binganalytics')
  </head>

    <body class="@yield('bodyClass') page-cart slimmer">
        @include('includes.googletagmanager')
        @include('includes.header')
        @yield('pre-content')
        @yield('content')
        @yield('post-content')
        @include('includes.footer')
        <div class="preloader">
            <img src="/images/icon-cart-hover.png" alt="">
        </div>
        <div class="loadingoverlay"></div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.ui.min.js"></script>
        @if(App::environment('production'))
        @include('includes.analytics')
        @endif
        @yield('lib-scripts')
        <script src="{{ asset('js/all.js') }}" type="text/javascript"></script>
        @yield('scripts')
        
        @if(isset($alert))
        <script>
        	(function(){
        		swal({
                  title: "{{ @$alert['title'] }}",
                  text: "{{ @$alert['message'] }}",
                  type: "{{ @$alert['type'] }}",
                  confirmButtonText: "{{ @$alert['button'] }}",
                  showConfirmButton: "{{ @$alert['showConfirmButton']}}",
                  timer: "{{ @$alert['timer'] }}",
                  html: true
        		});
        	})();
        </script>
        @endif
        @include('components.user-authentication')
        @yield('modals')
    </body>
</html>
