@extends('cart.layout')

@section('content')
<div class="page-title">
<h1>Oops!</h1>
</div>
<div class="group">
  <div style="min-height: 50%; max-height: 450px; text-align: center; padding: 15% 20%">

    <span class="fa fa-fw fa-3x fa-exclamation-circle text-danger"></span>
    <h3 class="text-danger">There was a problem processing your order. Please try again.</h3>
    <h5>If this problem persists, please contact <a href="mailto:webmaster@flavorgod.com">webmaster@flavorgod.com</a>.</h5>
    @if($payment_type == 'direct')
    <h5>Your credit card has <b>not</b> been charged.</h5>
    @else
    <h5>Your account has not <b>not</b> been charged.</h5>
    @endif
  </div>
</div>
<div class="group action-buttons">
  <div class="pull-left">
  <a href="{{ url('cart/payment') }}" class="btn btn-default">
    <span class="fa fa-fw fa-chevron-left"></span>
    <span>Back To Review &amp; Payment</span>
  </a>
  </div>
</div>
@stop