@extends('cart.layout')

@section('styles')

@stop

@section('content')
<div class="page-title">
  <a href="{{ url('store') }}" class="btn btn-default btn-nav-back">
    <span class="fa fa-fw fa-chevron-left"></span>
  </a>
  <h1><span class="fa fa-fw fa-shopping-cart card-icon"></span> Shopping Cart</h1>
</div>
<div class="shopping-cart">
  <div class="column-labels">
    <label class="product-image">Image</label>
    <label class="product-details">Product</label>
    <label class="product-price">Price</label>
    <label class="product-quantity">Quantity</label>
    <label class="product-removal">Remove</label>
    <label class="product-line-price">Total</label>
  </div>
  <form method="POST" role="form">
    @foreach($cart['items'] as $index => $item)
    <div class="product">
      <div class="product-image">
        <img src="/images/cart-pro-img-1.jpg">
      </div>
      <div class="product-details">
        <div class="product-title">{{ $item['name'] }}</div>
        <p class="product-description">Item # {{ $item['sku'] }}</p>
      </div>
      <div class="product-price" style="line-height:30px">{{ sprintf('%01.2f', $item['price']) }}</div>
      <div class="product-quantity">
        <input type="hidden" value="{{ $item['sku'] }}" name="items[{{ $index }}][sku]">
        <input class="txt-quantity" type="tel" value="{{ $item['quantity'] }}" min="1" name="items[{{ $index }}][quantity]" onfocus="this.select();" onmouseup="return false;">
      </div>
      <div class="product-removal">
        <button type="submit" class="load-hidden" name="_update" value="quantity">
          <span class="fa fa-fw fa-pencil fa-lg"></span>
        </button>
        <a href="{{ url('cart/?_remove='.$item['sku']) }}" class="btn btn-sm btn-danger btn-circle">
          <span class="fa-times-circle fa"></span>
        </a>
      </div>
      <div class="product-line-price" style="line-height:30px">{{ sprintf('%01.2f', $item['price'] * $item['quantity']) }}</div>
    </div>
    @endforeach
  </form>

  <div class="totals clearfix">
    <div class="totals-item">
      <label>Subtotal</label>
      <div class="totals-value" id="cart-subtotal">{{ sprintf('%1.2f', $cart['sub_total']) }}</div>
    </div>
    @if($cart['tax'])
    <div class="totals-item">
    <!-- Tax only applied if shipping address in NJ -->
      <label><abbr title="Estimated">Est.</abbr> Tax ({{ $cart['tax_rate'] * 100 }}%)</label>
      <div class="totals-value" id="cart-tax">{{ sprintf('%01.2f', $cart['tax']) }}</div>
    </div>
    @endif
    @if($cart['shipping_fee'])
    <div class="totals-item">
      <label><abbr title="Estimated">Est.</abbr>  Shipping</label>
      <div class="totals-value" id="cart-shipping">{{ sprintf('%01.2f', $cart['shipping_fee']) }}</div>
    </div>
    @else
    <form method="POST" role="form">
      <div class="totals-item" style="line-height: 30px; padding-top: 5px; padding-bottom: 5px">
        <label><abbr title="Calculate">Calc.</abbr> Shipping</label>
        <div class="totals-option">
          <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
            <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Zip Code">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit" name="_update" value="zipcode"><span class="fa fa-fw fa-calculator"></span></button>
            </span>
          </div>
        </div>
      </div>
    </form>
    @endif
    <form method="POST" role="form">
      <div class="totals-item" style="line-height: 30px; padding-top: 5px; padding-bottom: 5px">
        <label>Apply Discount</label>
        <div class="totals-option">
          <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
            <input type="text" class="form-control" name="coupon" id="coupon" placeholder="Coupon Code">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit" name="_update" value="coupon"><span class="fa fa-fw fa-tag"></span></button>
            </span>
          </div>
        </div>
      </div>
    </form>
    <div class="totals-item totals-item-total">
      <label><abbr title="Estimated">Est.</abbr> Grand Total</label>
      <div class="totals-value" id="cart-total">{{ sprintf('%01.2f', $cart['total']) }}</div>
    </div>
  </div>
  <div class="group action-buttons">
    <div class="pull-left  visible-lg">
      <a href="{{ url('store') }}" class="btn btn-default">
        <span class="fa fa-fw fa-chevron-left"></span>
        <span class="hidden-tablet">Continue Shopping</span>
      </a>
    </div>
    <div class="pull-right text-center">
      <a href="{{ url('cart/contact') }}" class="btn btn-primary btn-checkout">
        <span class="fa fa-fw fa-lg fa-shopping-cart"></span>
        <span class="">Checkout</span>
        <span class="fa fa-fw fa-chevron-right hidden-phone"></span>
      </a>
    </div>
  </div>
</div>
@stop