@extends('cart.layout')

@section('content')
<div class="cart-failed">

  <span class="fa fa-fw fa-3x fa-exclamation-circle text-danger"></span>
  <h3 class="text-danger">There was a problem processing your order. Please try again.</h3>
  <br>
  @if(empty($message))
  <h4>Your account has <b>not</b> been charged.</h4>
  @else
  <h4>{{ $message }}</h4>
  @endif
  <br>
  <h5>If this problem persists, please contact <a href="mailto:webmaster@flavorgod.com">webmaster@flavorgod.com</a>.</h5>
</div>
<div class="group buttons">
  <div class="text-center">
  <a href="{{ url('cart/payment') }}" class="btn btn-default">
    <span class="fa fa-fw fa-chevron-left"></span>
    <span>Back To Review &amp; Payment</span>
  </a>
  </div>
</div>
@stop
