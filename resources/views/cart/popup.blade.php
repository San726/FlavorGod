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
        <link rel="shortcut icon" type="/image/x-icon" href="{{ asset('favicon.ico') }}">
        <title></title>
        <script>
            var href = '{!! $redirect !!}';

            function closeAndRedirect() {
                if (window.opener) {
                    window.opener.document.location = href;
                    window.close();
                } else {
                    document.location.href = href;
                }
            }
        </script>
    </head>
    <body onload="closeAndRedirect()">
    </body>
</html>