@extends('cart.layout')
@section('styles')
@stop
@section('content')
<div class="container  cart-container cart-cart">

@if($store->test_mode == 1)
  <!-- GIFT AREA -->
  <div class="top-sale">
  <h3 class="titles text-center"><img src="https://flavorgod.s3.amazonaws.com/static/labor-day-sale-title.png" alt=""></h3>
  <div class="container">
    <div class="section shopping-cart">
      <div class="col-xs-4 col-sm-4 col-sale  no-gutter @foreach($cart['items'] as $index => $item) @if($item['sku'] == 'FG-T1') active @endif @endforeach">
        <div class="col-container">
          <h2>ANY ORDER</h2>
        <div class="internal">
          <h3>MEGA<span>EBOOK BUNDLE</span></h3>
          <img src="https://flavorgod.s3.amazonaws.com/static/ebooks.png" alt="">
          <div class="circle-value">
            <div class="dolar">$210</div>
            <div class="text">VALUE</div>
          </div>
          <div class="not-apply">$1<span class="value-left"></span> LEFT to qualify
            <a href="/shop">continue shopping & qualify</a>
          </div>
          <div class="apply"><i class="fa fa-check" aria-hidden="true"></i>APPLIED TO YOUR CART!</div>
        </div>
        </div>
      </div>

      <div class="col-xs-4 col-sm-4 col-sale no-gutter @foreach($cart['items'] as $index => $item) @if($item['sku'] == 'FG-T2') active @endif @endforeach" id="apron">
        <div class="col-container">
          <h2>ORDERS <span>$<span class="value-need">50</span>+</span></h2>
        <div class="internal">
          <h3>FLAVORGOD<span>CHEF APRON</span></h3>
          <img src="https://flavorgod.s3.amazonaws.com/static/appron.png" alt="">
          <div class="circle-value">
            <div class="dolar">$30</div>
            <div class="text">VALUE</div>
          </div>
          <div class="not-apply">$<span class="value-left"></span> LEFT to qualify
            <a href="/shop">continue shopping & qualify</a>
          </div>
          <div class="apply"><i class="fa fa-check" aria-hidden="true"></i>APPLIED TO YOUR CART!</div>
        </div>
        </div>
      </div>

      <div class="col-xs-4 col-sm-4 col-sale no-gutter @foreach($cart['items'] as $index => $item) @if($item['sku'] == 'FG-T3') active @endif @endforeach" id="mystery">
        <div class="col-container">
          <h2>ORDERS <span>$<span class="value-need">99</span>+</span></h2>
        <div class="internal">
        <h3>SURPRISE<span>MYSTERY SPICE</span></h3>
          <img src="https://flavorgod.s3.amazonaws.com/static/spice.png" alt="">
          <div class="circle-value">
            <div class="dolar">$30</div>
            <div class="text">VALUE</div>
          </div>
          <div class="not-apply">$<span class="value-left"></span> LEFT to qualify
            <a href="/shop">continue shopping & qualify</a>
          </div>
          <div class="apply"><i class="fa fa-check" aria-hidden="true"></i>APPLIED TO YOUR CART!</div>
        </div>
        </div>
      </div>
    </div>
  </div>

  </div>
  <!-- /END OF GIFT AREA -->
@endif


  @if($converted)
    <div class="container section cart-empty" style="padding: 10px 10px 30px">
      <div class="group">
          <div style="max-height: 450px; text-align: center;">
            <span class="fa fa-fw fa-exclamation-circle text-success"></span>
              <h3 class="text-success">Your payment has successfully been accepted for this cart. Your order transaction reference is:</h3>
              <h3>{{ @$converted->transaction_ref }}</h3>
              <a style="font-size:20px;font-weight:bolder;" href="{{ url() }}">Shop</a>
              </div>
      </div>
    </div>
  @else
    @if(!count($cart['items']))
    <div class="container section cart-empty" style="padding: 10px 10px 30px">
      <div class="group">
        <div style="min-height: 50%; max-height: 450px; text-align: center; color: #D2d2d2;">
          <h3 class="" style="
          color: #666;
          text-transform: none;
          font-size: 30px;
          margin-bottom: 50px;
          ">There doesn't seem to be anything here.</h3>
          <span class="fa fa-fw fa-lg fa-shopping-cart" style="
            margin-bottom: 30px;
          "></span>
          <h5 style="
          text-transform: none;
          font-size: 19px;
          max-width: 500px;
          margin: 0 auto;
          color: #ACACAC;
          ">If you were expecting something, your session may have timed out and cleared your shopping cart.</h5>
        </div>
        <div class="text-center">
          <a href="/shop" class="btn btn-default btn-checkout">
            <span class="fa fa-lg fa-shopping-cart hidden-phone"></span>
            <span class="">Go to shop</span>
          </a>
        </div>
      </div>
    </div>
    @endif


    <h3 class="cart-titles text-center">YOUR CART</h3>
    <div class="section shopping-cart">
      <div class="alert alert-success memorial-day-sale-alert" role="alert">Highest discount already applied. </div>
      <div class="column-labels">
        <label class="product-image">Image</label>
        <label class="product-details">Product</label>
        <label class="product-price">Price</label>
        <label class="product-quantity">Quantity</label>
        <label class="product-removal">Remove</label>
        <label class="product-line-price">Total</label>
      </div>
      <form method="POST" role="form">
        {!! csrf_field() !!}
        @foreach($cart['items'] as $index => $item)
        <div class="product">
          <div class="product-image">
            <img src="{{ @$item['assets']['primary_image']['path'] }}" alt="{{ $item['name'] }}" title="{{ $item['name'] }}">
          </div>
          <div class="product-details">
            <div class="product-title">{{ $item['name'] }}</div>
            <p class="product-description">Item # {{ $item['sku'] }}</p>
          </div>
          <div class="product-price" style="line-height:30px">{{ sprintf('%01.2f', $item['price']) }}</div>

          @if($store->test_mode == 1)
              @if(in_array($item['sku'], $freeGiftsSkus))
                <div class="product-quantity">
                  <span class="gift-quantity">
                    {{ $item['quantity'] }}
                  </span>
                </div>
                <div class="product-removal">
                  <div class="btn btn-sm btn-danger btn-circle">
                    <span class=""></span>
                  </div>
                </div>
              @else
                <div class="product-quantity">
                <input type="hidden" value="{{ $item['sku'] }}" name="items[{{ $index }}][sku]">
                <input class="txt-quantity" type="tel" value="{{ $item['quantity'] }}" min="1" name="items[{{ $index }}][quantity]" onfocus="this.select();" onmouseup="return false;">
                <button id="submit_quantity" type="submit" class="load-hidden" name="_update" value="quantity">
                </button>
              </div>
              <div class="product-removal">
                <button type="submit" class="load-hidden" name="_update" value="quantity">
                <span class="fa fa-fw fa-pencil fa-lg"></span>
                </button>
                <a href="{{ url('cart/?_remove='.$item['sku']) }}" class="btn btn-sm btn-danger btn-circle">
                  <span class="fa-times-circle fa"></span>
                </a>
              </div>
            @endif
          @else
            <div class="product-quantity">
              <input type="hidden" value="{{ $item['sku'] }}" name="items[{{ $index }}][sku]">
              <input class="txt-quantity" type="tel" value="{{ $item['quantity'] }}" min="1" name="items[{{ $index }}][quantity]" onfocus="this.select();" onmouseup="return false;">
              <button id="submit_quantity" type="submit" class="load-hidden" name="_update" value="quantity">
              </button>
            </div>
            <div class="product-removal">
              <button type="submit" class="load-hidden" name="_update" value="quantity">
              <span class="fa fa-fw fa-pencil fa-lg"></span>
              </button>
              <a href="{{ url('cart/?_remove='.$item['sku']) }}" class="btn btn-sm btn-danger btn-circle">
                <span class="fa-times-circle fa"></span>
              </a>
            </div>
          @endif


          <div class="product-line-price" style="line-height:30px">{{ sprintf('%01.2f', $item['price'] * $item['quantity']) }}</div>
        </div>
        @endforeach
        @foreach($cart['discounts'] as $discount)
        <div class="product coupon-info col-xs-12 no-right">
          <div class="text-left col-md-8 col-xs-6 no-right">
            <span class="coupon-label">
              COUPON:
            </span>
            <code>
            <span class="coupon-value">
              {{ $discount['code'] }}</span></code>
              <a style="font-size:13px" href="/cart/discounts/remove/{{ $discount['code'] }}"> Remove</a>
          </div>
          <div class="text-right col-md-4 col-xs-6 no-right">
            <span style="font-weight:bold;margin-right:20px;">
              @if($discount['type']=='percentage') {{ $discount['value'] }}% OFF APPLIED:
              @else AMOUNT OFF:
              @endif
            </span>
            <span>- $ {{ sprintf('%01.2f', $discount['applied_value']) }}</span></div>
        </div>
        @endforeach
      </form>





      <!-- End of coupon -->

      <div class="totals clearfix">

        <!-- Coupon product line -->
         <div class="coupon-apply clearfix">
              <form class="" method="POST" role="form" id="form-cart">
                  {!! csrf_field() !!}
                  <div class="totals-item" >
                    <div class="pull-right">
                      <div class="input-group input-group-sm pull-right no-right" >
                        <input type="text" name="coupon" id="coupon"  style="font-size: 15px" >
                        <label for="coupon">Coupon Code</label>
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="submit" name="_update" value="coupon">Apply</button>
                        </span>
                      </div>
                    </div>
                  </div>
              </form>
          </div>



        <div class="totals-item">
          <label>Subtotal</label>
          <div class="totals-value" id="cart-subtotal">{{ sprintf('%1.2f', $cart['sub_total']) }}</div>
        </div>
        @if($cart['discounts'])
         <div class="totals-item">
          <label>Coupon</label>
          <div class="totals-value" id="cart-subtotal">- {{ sprintf('%01.2f', $discount['applied_value']) }}</div>
        </div>
        @endif
        @if($cart['tax'])
        <div class="totals-item">
          <!-- Tax only applied if shipping address in NJ -->
          <label>Tax ({{ $cart['tax_rate'] * 100 }}%)</label>
          <div class="totals-value" id="cart-tax">{{ sprintf('%01.2f', $cart['tax']) }}</div>
        </div>
        @endif
        @if(!is_null($cart['shipping_fee']))
        <div class="totals-item">
          <label>Shipping</label>
          <div class="totals-value" id="cart-shipping">{{ sprintf('%01.2f', $cart['shipping_fee']) }}</div>
        </div>
        @else
        <form method="POST" role="form">
          {!! csrf_field() !!}
          <div class="totals-item cart-page">
            <label><abbr title="Calculate">Calc.</abbr> Shipping</label>
            <div class="totals-option">
              <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
                <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Zip Code">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit" name="_update" value="zipcode"><span class="fa fa-fw fa-calculator"></span></button>
                </span>
              </div>
            </div>
          </div>
        </form>
        @endif
        @if(($cart['handling_fee'] > 0))
        <div class="totals-item">
          <!-- Handling Fee Adjustments -->
          <label>Handling Fee</label>
          <div class="totals-value" id="cart-handling">{{ number_format($cart['handling_fee'], 2) }}</div>
        </div>
        @endif
        <div class="totals-item totals-item-total">
          <label>Total</label>
          <div class="totals-value" id="cart-total">{{ sprintf('%01.2f', $cart['total']) }}</div>
        </div>
      </div>
      <div class="group action-buttons">
        <div class="pull-left  visible-lg">
          <a href="{{ url('shop') }}" class="btn btn-transparent">
            <span class="fa fa-fw fa-chevron-left"></span>
            <span class="hidden-tablet">Continue Shopping</span>
          </a>
        </div>
        <div class="pull-right text-center">
          <a href="{{ url('cart/contact') }}" class="btn btn-default btn-checkout" style=" color :#fff">
            <span class="">Checkout</span>
            <span class="fa fa-fw fa-chevron-right hidden-phone"></span>
          </a>
        </div>
      </div>
    </div>
  @endif
</div>
<style>
.memorial-day-sale-alert {
  display:none;
}
</style>
<!--   <div class=" suggested container  cart-container cart-cart">
  <div class="sec-product section">
    <h4>Customers Who Bought Items in Your Cart Also Bought</h4>
    <div class="store-details">
      <ul class="row">
        <li class="absolute-xs-2" data-product-set="index mannys-cart" >
          <div class="prod-single prod-red">
            <a href="/shop/product/spicy-everything-seasoning" class="prod-img" title="Spicy Everything Seasoning">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447863_primary_image.jpg" alt="Spicy Everything Seasoning" title="Spicy Everything Seasoning">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447863_icon_circle.png" alt="Spicy Everything Seasoning" title="Spicy Everything Seasoning">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/spicy-everything-seasoning" title="Spicy Everything Seasoning">Spicy Everything Seasoning</a></h2>
              <h3>
              <small>$9.99</small>
              <span>$8.99</span>
              </h3>
            </div>
          </div>
        </li>
        <li class="absolute-xs-2" data-product-set="classic apparel-books combo-sets thank-you-array index mannys-cart">
          <div class="prod-single prod-red">
            <a href="/shop/product/dynamite-combo-set" class="prod-img" title="Dynamite Combo Set">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/COMBO-DYN_primary_image.jpg" alt="Dynamite Combo Set" title="Dynamite Combo Set">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/COMBO_SPECIAL_icon_circle.png" alt="Dynamite Combo Set" title="Dynamite Combo Set">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/dynamite-combo-set" title="Dynamite Combo Set">Dynamite Combo Set</a></h2>
              <h3>
              <small>$69.95</small>
              <span>$29.99</span>
              </h3>
            </div>
          </div>
        </li>
        <li class="absolute-xs-2" data-product-set="limited-edition index">
          <div class="prod-single prod-red">
            <a href="/shop/product/chipotle-seasoning" class="prod-img" title="Chipotle Seasoning">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/811207026720_primary_image.jpg" alt="Chipotle Seasoning" title="Chipotle Seasoning">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/811207026720_icon_circle.png" alt="Chipotle Seasoning" title="Chipotle Seasoning">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/chipotle-seasoning" title="Chipotle Seasoning">Chipotle Seasoning</a></h2>
              <h3>
              <small>$29.99</small>
              <span>$14.99</span>
              </h3>
            </div>
          </div>
        </li>
        <li class="absolute-xs-2" data-product-set="index mannys-cart" >
          <div class="prod-single prod-red">
            <a href="/shop/product/spicy-everything-seasoning" class="prod-img" title="Spicy Everything Seasoning">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447863_primary_image.jpg" alt="Spicy Everything Seasoning" title="Spicy Everything Seasoning">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447863_icon_circle.png" alt="Spicy Everything Seasoning" title="Spicy Everything Seasoning">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/spicy-everything-seasoning" title="Spicy Everything Seasoning">Spicy Everything Seasoning</a></h2>
              <h3>
              <small>$9.99</small>
              <span>$8.99</span>
              </h3>
            </div>
          </div>
        </li>
        <li class="absolute-xs-2" data-product-set="classic apparel-books combo-sets thank-you-array index mannys-cart">
          <div class="prod-single prod-red">
            <a href="/shop/product/804879447856" class="prod-img" title="Everything Seasoning">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447856_primary_image.jpg" alt="Everything Seasoning" title="Everything Seasoning">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447856_icon_circle.png" alt="Everything Seasoning" title="Everything Seasoning">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/804879447856" title="Everything Seasoning">Everything Seasoning</a></h2>
              <h3>
              <small>$9.99</small>
              <span>$8.99</span>
              </h3>
            </div>
          </div>
        </li>
        <li class="absolute-xs-2" data-product-set="limited-edition index">
          <div class="prod-single prod-red">
            <a href="/shop/product/chipotle-seasoning" class="prod-img" title="Chipotle Seasoning">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/811207026720_primary_image.jpg" alt="Chipotle Seasoning" title="Chipotle Seasoning">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/811207026720_icon_circle.png" alt="Chipotle Seasoning" title="Chipotle Seasoning">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/chipotle-seasoning" title="Chipotle Seasoning">Chipotle Seasoning</a></h2>
              <h3>
              <small>$29.99</small>
              <span>$14.99</span>
              </h3>
            </div>
          </div>
        </li>
        <li class="absolute-xs-2" data-product-set="index mannys-cart" >
          <div class="prod-single prod-red">
            <a href="/shop/product/spicy-everything-seasoning" class="prod-img" title="Spicy Everything Seasoning">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447863_primary_image.jpg" alt="Spicy Everything Seasoning" title="Spicy Everything Seasoning">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447863_icon_circle.png" alt="Spicy Everything Seasoning" title="Spicy Everything Seasoning">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/spicy-everything-seasoning" title="Spicy Everything Seasoning">Spicy Everything Seasoning</a></h2>
              <h3>
              <small>$9.99</small>
              <span>$8.99</span>
              </h3>
            </div>
          </div>
        </li>
        <li class="absolute-xs-2" data-product-set="classic apparel-books combo-sets thank-you-array index mannys-cart">
          <div class="prod-single prod-red">
            <a href="/shop/product/804879447856" class="prod-img" title="Everything Seasoning">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447856_primary_image.jpg" alt="Everything Seasoning" title="Everything Seasoning">
                  <div class="prod-overlay">
                    <div class="dis-table">
                      <div class="dis-table-cell">
                        <p>
                          <img src="http://test.foo/images/prod-hover.png" alt="click to Learn More" title="click to Learn More">
                          <span>click to Learn More</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="prod-cat">
              <div class="dis-table">
                <div class="dis-table-cell">
                  <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/804879447856_icon_circle.png" alt="Everything Seasoning" title="Everything Seasoning">
                </div>
              </div>
            </div>
            <div class="prod-descr">
              <h2><a href="shop/product/804879447856" title="Everything Seasoning">Everything Seasoning</a></h2>
              <h3>
              <small>$9.99</small>
              <span>$8.99</span>
              </h3>
            </div>
          </div>

        </ul>
      </div>
    </div>
  </div> -->
  @stop
  @section('scripts')
  <script type="text/javascript" src="{{ asset('js/libs/jquery.payment.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/pages/cart.js') }}"></script>
  @stop
