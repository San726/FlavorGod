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
    <title>@section('title')Flavorgod Checkout @show</title>
    @else
    <title>{{ strtoupper(App::environment()) }} - Flavorgod Checkout</title>
    @endif
    <!--[if lte IE 8]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="/image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:700,300italic%7cSource+Sans+Pro:400,200,300,600,700,900,600italic,700italic%7cLato:100,300,400,700,900%7cPT+Sans:400,700,400italic,700italic">
    @yield('fonts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("css/paypal.css") }}">
    @yield("styles")
    @yield("top-scripts")
  </head>

    <body class="@yield('bodyClass') cart-page">
        @include('includes.header')
        @yield('pre-content')
        @yield('content')
        @yield('post-content')
        @include('includes.footer')
        <div class="preloader">
            <img src="/images/icon-cart-hover.png" alt="">
        </div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.ui.min.js"></script>
        @yield('lib-scripts')
        <script src="{{ asset('js/all.js') }}" type="text/javascript"></script>
        @yield('scripts')
        {{-- Start Visual Website Optimizer Asynchronous Code --}}
        <script type='text/javascript'>
        var _vwo_code=(function(){
        var account_id=203593,
        settings_tolerance=2000,
        library_tolerance=2500,
        use_existing_jquery=false,
        f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById('_vis_opt_path_hides');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement('script');b.src=a;b.type='text/javascript';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName('head')[0].appendChild(b);},init:function(){settings_timer=setTimeout('_vwo_code.finish()',settings_tolerance);var a=d.createElement('style'),b='body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}',h=d.getElementsByTagName('head')[0];a.setAttribute('id','_vis_opt_path_hides');a.setAttribute('type','text/css');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);this.load('//dev.visualwebsiteoptimizer.com/j.php?a='+account_id+'&u='+encodeURIComponent(d.URL)+'&r='+Math.random());return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();
        </script>
        {{-- End Visual Website Optimizer Asynchronous Code --}}
        {{-- Yandex.Metrika counter --}}
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter33883519 = new Ya.Metrika({
                            id:33883519,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/33883519" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        {{-- /Yandex.Metrika counter --}}
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
    </body>
</html>
