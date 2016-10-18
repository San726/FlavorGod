@extends('cart.layout')

@section('top-scripts')
@if(App::environment('production'))
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', 'xxxxxxxxxxxxxxxx');
fbq('track', 'Purchase', {value: '{{ $order["total"] }}', currency: 'USD'});
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1481947045413841&ev=PageView&noscript=1"></noscript>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 000000000;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "XxXxXxXxXxXxXxXxXxX";
var google_conversion_value = {{ $order['total'] }};
var google_conversion_currency = "USD";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/000000000/?value=1.00&amp;currency_code=USD&amp;label=XxXxXxXxXxXxXxXxXxX&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
@else
<!-- T R A C K I N G   C O D E S -->
@endif
@stop

@section('content')
<div class="page-title">
  <h1 class="text-success"><span class="fa fa-fw fa-check card-icon"></span>Payment Successful</h1>
</div>
<div class="group" style="padding: 5px 0 15px; border-bottom: 1px solid #eee; margin-bottom: 10px">
  <h4>Thank you for your purchase.</h4>
  <span>Your account has been charged and order will be processed momentarily.</span>
</div>
<div class="shopping-cart">
  <div class="column-labels">
    <label class="product-image">Image</label>
    <label class="product-details">Product</label>
    <label class="product-removal">Remove</label>
    <label class="product-price">Price</label>
    <label class="product-quantity">Quantity</label>
    <label class="product-line-price">Total</label>
  </div>
  @foreach($cart['items'] as $index => $item)
  <div class="product">
    <div class="product-image">
      <img src="//s3.amazonaws.com/SHREDZ-CARTS/products/en/{{ $item['sku'] }}/primaryimage_01.jpg">
    </div>
    <div class="product-details">
      <div class="product-title">{{ $item['name'] }}</div>
      <p class="product-description">Item # {{ $item['sku'] }}</p>
    </div>
    <div class="product-removal">&nbsp;</div>
    <div class="product-price" style="line-height:30px">{{ sprintf('%01.2f', $item['price']) }}</div>
    <div class="product-quantity" style="line-height: 30px">
      {{ $item['quantity'] }}
    </div>
    <div class="product-line-price" style="line-height:30px">{{ sprintf('%01.2f', $item['price'] * $item['quantity']) }}</div>
  </div>
  @endforeach

  <div class="totals clearfix">
    <div class="totals-item">
      <label>Subtotal</label>
      <div class="totals-value" id="cart-subtotal">{{ sprintf('%1.2f', $cart['sub_total']) }}</div>
    </div>
    @if($cart['tax'])
    <div class="totals-item">
    <!-- Tax only applied if shipping address in NJ -->
      <label>Tax ({{ $cart['tax_rate'] * 100 }}%)</label>
      <div class="totals-value" id="cart-tax">{{ sprintf('%01.2f', $cart['tax']) }}</div>
    </div>
    @endif
    @if($cart['shipping_fee'])
    <div class="totals-item">
      <label>Shipping</label>
      <div class="totals-value" id="cart-shipping">{{ sprintf('%01.2f', $cart['shipping_fee']) }}</div>
    </div>
    @endif
    <div class="totals-item totals-item-total">
      <label>Grand Total</label>
      <div class="totals-value" id="cart-total">{{ sprintf('%01.2f', $cart['total']) }}</div>
    </div>
  </div>
  <div class="group action-buttons">
    <div class="pull-left">
      <a href="{{ url('store') }}" class="btn btn-default">
        <span class="fa fa-fw fa-chevron-left"></span>
        <span class="">Back To Store</span>
      </a>
    </div>
  </div>
</div>
@stop