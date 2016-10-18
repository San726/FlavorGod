@extends('cart.layout')

@section('content')

@if(App::environment('production'))

{{-- Only want to track CJ for flavorgod.com, not subdomains. --}}
@if($is_root_domain)
    {{-- ## START CJ Tracking ## --}}
    <?php
      $cj_items_str = '';
      $i=1;
        foreach (@$cart['items'] as $item) {
            $this_item_str = "ITEM" . $i . "=" . rawurlencode($item['sku'])
                . "&AMT" . $i . "=" . number_format($item['price'], 2, '.', '')
                . "&QTY" . $i . "=" . $item['quantity'];
            if ($i > 1){
                $cj_items_str .= "&";
            }
            $cj_items_str .= $this_item_str;
            $i++;
     }
     ?>
     <iframe height="1" width="1" frameborder="0" scrolling="no" src="https://www.emjcd.com/tags/c?containerTagId=14851&CID=1538046&OID={{ @$cart['transaction_ref'] }}&TYPE=386934&CURRENCY=USD&DISCOUNT={{ number_format($cart['discount_total'], 2, '.', '') }}&{{ $cj_items_str }}"
      name="cj_conversion" ></iframe>
    {{-- ## END CJ Tracking ## --}}
@endif

{{-- ## Pinterest ## --}}
<img height="1" width="1" style="display:none;" alt="" src="https://ct.pinterest.com/?tid=vZw8CEqOG5M&value={!! number_format($cart['total'], 2, '.', '') !!}&quantity=1">

{{-- F A C E B O O K   T R A C K I N G   C O D E S --}}
<script>
    var cart_items = {!! json_encode(@$cart['items'] ?: []) !!};
    var skus = [];

    for(var item, i = 0, l = cart_items.length; i < l; i++) {
      item = cart_items[i];

    skus.push(item['sku']);
    }
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','//connect.facebook.net/en_US/fbevents.js');

    fbq('init', '661731167306509');
    fbq('track', "PageView");
    fbq('track', 'Purchase', {
      'value': '{{ number_format($cart["total"], 2, '.', '') }}',
      'currency': 'USD',
      'content_type': 'product',
      'content_ids': skus
    });
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=661731167306509&ev=PageView&noscript=1"/></noscript>
{{-- A D W O R D S   T R A C K I N G   C O D E S --}}
<!-- START - Google Conversion Tag - Flavor God -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 922326724;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "sRByCKOu-mUQxK3mtwM";
var google_conversion_value = {{ number_format($cart['total'], 2, '.', '') }};
var google_conversion_currency = "USD";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/922326724/?value={{ number_format($cart['total'], 2, '.', '') }}&amp;currency_code=USD&amp;label=sRByCKOu-mUQxK3mtwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<img src="https://wehandle.email/pub/cct?_ri_=X0Gzc2X%3DYQpglLjHJlTQGtzacMzae2p6NY7vMeLflBMrs&_ei_=EppZiT4L1wvGnAmz4-e_U9s&action=once&OrderID={{ @$cart['uid'] }}&OrderTotal={{ number_format($cart['total'], 2, '.', '') }}&NumItem={{ @$cart['item_count'] }}" width="1" height="1">

<!-- Google Analytics Conversion Tag - Flavor God -->
<script>
     // ** Trigger Google conversion trackers ** //
    var cart_items      = {!! json_encode(@$cart['items'] ?: []) !!};
    var cart_discounts  = {!! json_encode(@$cart['discounts'] ?: []) !!};
    var cart_total      = {!! json_encode(@$cart['total'] ?: 0) !!};
    var cart_tax        = {!! json_encode(@$cart['tax'] ?: 0) !!};
    var cart_shipping   = {!! json_encode(@$cart['shipping_fee'] ?: 0) !!};
    var cart_uid        = {!! json_encode(@$cart['uid'] ?: 'XxxXxxXxx') !!};
    var trans_ref       = {!! json_encode(@$cart['transaction_ref'] ?: 'XxxXxxXxx') !!};
    var cart_custom     = {!! json_encode(@$cart['custom'] ?: 'XxxXxxXxx') !!};

    // ** Prepare containers for derived values ** //
    var coupons = [];
    var skus = [];

    // ** Extract discount codes ** //
    for(var discount, i = 0, l = cart_discounts.length; i < l; i++) {
      discount = cart_discounts[i];

      if (discount.applied_value) {
        coupons.push(discount.code);
      }
    }

    // ** Require Google ecommerce tracking ** //
    ga('require', 'ecommerce');

    // ** Trigger Google conversion trackers ** //
    ga('ecommerce:addTransaction', {
      'id': trans_ref,
      'affiliation': cart_custom,
      'revenue': cart_total.toFixed(2),
      'tax': cart_tax.toFixed(2),
      'shipping': cart_shipping.toFixed(2),
      'coupon': coupons.join(',')  // User added a coupon at checkout. // Important
    });

    // ** Extract item skus and perform individual item triggers ** //
    for(var item, i = 0, l = cart_items.length; i < l; i++) {
      item = cart_items[i];
      skus.push(item['sku']);

      ga('ecommerce:addItem', {
        'id': trans_ref,
        'name': item['name'],
        'sku': item['sku'],
        'category': '',
        'brand': '',
        'variant': '',
        'price': item['price'].toFixed(2),
        'quantity': item['quantity'].toFixed(0)
      });
    }

    // ** Send Ecommerce Data ** //
    ga('ecommerce:send');
</script>
<!-- END Google Conversion Tag - Flavor God -->

@else
<!-- T R A C K I N G   C O D E S -->
@endif
<div class="cart-page cart-success">

    <div class=" container cart-success">

    <div class="section">
        <div class="page-title">
            <h1 class="text-success"><span class="fa fa-fw fa-check card-icon"></span>Payment Successful</h1>
        </div>
        <div class="group" style="padding: 5px 0 15px; border-bottom: 1px solid #eee; margin-bottom: 10px">
            <h4 class="text-success">Thank you for your purchase.</h4>
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
                    <img src="{{ $item['assets']['primary_image']['path'] }}">
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
                @endif @if($cart['shipping_fee'])
                <div class="totals-item">
                    <label>Shipping</label>
                    <div class="totals-value" id="cart-shipping">{{ sprintf('%01.2f', $cart['shipping_fee']) }}</div>
                </div>
                @endif
                @if($cart['discount_total'])
                <div class="totals-item">
                    <label>Discount Amount</label>
                    <div class="totals-value" id="cart-shipping">-{{ sprintf('%01.2f', $cart['discount_total']) }}</div>
                </div>
                @endif
                @if(Session::get('creditApplied') > 0)
                <div class="totals-item">
                    <label>Store Credit</label>
                    <div class="totals-value" id="cart-shipping">-{{ sprintf('%01.2f', Session::get('creditApplied')) }}</div>
                </div>
                @endif
                <div class="totals-item totals-item-total">
                    <label>Grand Total</label>
                    @if(Session::get('creditApplied') > 0)
                        <div class="totals-value" id="cart-total">{{ sprintf('%01.2f', $cart['total'] - Session::get('creditApplied')) }}</div>
                    @else
                        <div class="totals-value" id="cart-total">{{ sprintf('%01.2f', $cart['total']) }}</div>
                    @endif
                </div>
            </div>
            <div class="group action-buttons">
                <div class="pull-left">
                    <a href="{{ url('shop') }}" class="btn btn-default">
                        <span class="fa fa-fw fa-chevron-left"></span>
                        <span class="">Back To Store</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>


</div>

@stop
