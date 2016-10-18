@extends('cart.layout')

@section('content')

<div class="container">

<div class="section">

<div class="group">
  <div style="min-height: 50%; max-height: 450px; text-align: center; padding: 15% 20%">
    <span class="fa fa-fw fa-3x fa-exclamation-circle text-danger"></span>
    <h3 class="text-danger">An error has occurred.</h3>
    <h5>If this problem persists, please contact <a href="mailto:webmaster@flavorgod.com">webmaster@flavorgod.com</a> or send us a <a href="/contact">message</a>.</h5>
    <h5>This error has been logged in our system and will be assesed ASAP.</h5>
  </div>
</div>
<div class="group">
  <div class="text-center">
  <a href="{{ url('cart') }}" class="btn btn-transparent outline">
    <span class="fa fa-fw fa-shopping-cart"></span>
    <span>Go to Shop</span>
  </a>
  </div>
</div>

</div>

</div>
@stop