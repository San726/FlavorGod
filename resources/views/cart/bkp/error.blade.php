@extends('cart.layout')

@section('content')
<div class="page-title">
<h1 class="text-danger"><span class="fa fa-bomb fa-fw card-icon"></span> This isn't good!</h1>
</div>
<div class="group">
  <div style="min-height: 50%; max-height: 450px; text-align: center; padding: 15% 20%">

    <span class="fa fa-fw fa-3x fa-exclamation-circle text-danger"></span>
    <h3 class="text-danger">An error has occurred.</h3>
    <h5>This error has been logged in our system and will be assesed ASAP.</h5>
  </div>
</div>
<div class="group action-buttons">
  <div class="pull-left">
  <a href="{{ url('cart') }}" class="btn btn-default">
    <span class="fa fa-fw fa-chevron-left"></span>
    <span>Back to Cart</span>
  </a>
  </div>
</div>
@stop