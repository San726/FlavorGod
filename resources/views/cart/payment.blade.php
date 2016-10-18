@extends('cart.layout') @section('content')
<!---------------------------------------------------------------------------- [1] Contact ------------------------------------------------------------------------------>

<div class="cart-page cart-payment form">
    <!--BREADCRUMB-->
    <div class="container">
        <ol class="breadcrumb row">
            <li><a href="#">Cart</a></li>
            <li><a href="#">Shipping Address</a></li>
            <li class="active">Payment & Billing</li>
        </ol>
    </div>


    <div class="container  order-summary">

        <div class="section row">
            <div class="order-summary--header col-xs-12">
                <div class="pull-left">
                    <h2><b class="fa fa-fw fa-shopping-cart"></b>Show order summary <b class="fa fa-chevron-down"></b></h2>
                </div>
                <div class="pull-right hidden-xs">
                     @if($creditApplied > 0.00)
                            <h2 class="total">$ {{ number_format($cart['total'] - $creditApplied, 2) }}</h2>                               
                        @else
                            <h2 class="total">$ {{ number_format($cart['total'], 2) }}</h2>                             
                        @endif 
                </div>
            </div>

            <div class="summary load-hidden">
                <div class="col-xs-12">

                    <div class="column-labels">
                        <label class="product-image">Image</label>
                        <label class="product-details">Product</label>
                        <label class="product-price">Price</label>
                        <label class="product-quantity">Quantity</label>
                        <label class="product-removal">Remove</label>
                        <label class="product-line-price">Total</label>
                    </div>
                    @foreach($cart['items'] as $item)

                    <div class="product cart-table">
                        <div class="product-image">
                            <img src="{{ $item['assets']['primary_image']['path'] }}">
                        </div>
                        <div class="product-details">
                            <div class="product-title">{{ $item['name'] }}</div>
                            <p class="product-description">Item # {{ $item['sku'] }}</p>
                        </div>
                        <div class="product-price" style="line-height:30px">{{ number_format($item['price'], 2) }}</div>
                        <div class="product-quantity">
                            {{ $item['quantity'] }}

                        </div>
                        <div class="product-line-price pull-right" style="line-height:30px">{{ number_format($item['price'], 2) }}</div>
                    </div>



                    @endforeach


                    <div class="totals clearfix col-xs-12 col-md-6 pull-right no-right">
                        <div class="totals-item">
                            <label>Subtotal</label>
                            <div class="totals-value" id="cart-subtotal">{{ $cart['sub_total'] }}</div>
                        </div>
                        @if($cart['tax'] > 0)
                        <div class="totals-item">
                            <!-- Tax only applied if shipping address in NJ -->
                            <label>Tax (7%)</label>
                            <div class="totals-value" id="cart-tax">{{ number_format($cart['tax'], 2) }}</div>
                        </div>
                        @endif

                        <div class="totals-item">
                            <label>Shipping</label>
                            <div class="totals-value" id="cart-shipping">{{ number_format($cart['shipping_fee'], 2) }}</div>
                        </div>
                        @if($cart['handling_fee'] > 0)
                        <div class="totals-item">
                            <!-- Handling Fee Adjustments -->
                            <label>Handling Fee</label>
                            <div class="totals-value" id="cart-handling">{{ number_format($cart['handling_fee'], 2) }}</div>
                        </div>
                        @endif
                        @if($cart['discount_total'] > 0)
                        <div class="totals-item" style=" padding-top: 5px; padding-bottom: 5px">
                            <label><span>Coupon</span></label>
                            <div class="totals-option">
                                <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
                                    <div class="coupon-discount">- $ {{ number_format($cart['discount_total'], 2) }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($creditApplied > 0.00)
                            <div class="totals-item" style=" padding-top: 5px; padding-bottom: 5px">
                                <label><span>Store Credit</span></label>
                                <div class="totals-option">
                                    <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
                                        <div class="coupon-discount">- $ {{ number_format($creditApplied, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($creditApplied > 0.00)
                            <div class="totals-item totals-item-total">
                                <label>Total</label>
                                <div class="totals-value" id="cart-total">{{ number_format($cart['total'] - $creditApplied, 2) }}</div>
                            </div>
                        @else
                            <div class="totals-item totals-item-total">
                                <label>Total</label>
                                <div class="totals-value" id="cart-total">{{ number_format($cart['total'], 2) }}</div>
                            </div>
                        @endif
                    </div>

                    <!--END OF TOTALS-->


                    <!--End of Static summary for design development-->


                </div>

            </div>

        </div>
    </div>

    <div class=" section-container">

        <!--SUMMARY-->



        <div class="">

            <!---------------------------------------------------------------------------- [3] 1 - Payment ------------------------------------------------------------------------------>

            <div class="container cart-container">
                @if($cart['total'] > $creditApplied)
                 <div class="page-subtitle">
                    <h2>Payment Method</h2>                    
                    <p>All transactions are secure and encrypted. Credit card information never stored.</p>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors as $field => $messages)
                            <h5>{{ $field }}</h5>
                            <ul>
                                @foreach($messages as $message)
                                <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="form-group clearfix payment-section panel-block">
                    <!--PAYMENT-->
                    <form class="form-horizontal" method="POST" role="form" action="/cart/payment" novalidate>
                        {!! csrf_field() !!}
                        <!--Credit Card Panel-->
                        <div class="panel panel-default credit-card-box active">
                            <div class="panel-heading clearfix">
                                <div class="title-content title-content--payment col-xs-5 no-gutter">
                                    <h4>
                                        <i class="fa fa-check-circle"></i>
                                        <b class="fa fa-fw fa-credit-card hidden-xs"></b>Credit Card
                                    </h4>
                                </div>
                                <div class="title-icons col-xs-7 text-right no-right">
                                    <img src="../images/checkout/visa.svg" onerror="this.src='../images/payment/visa.png'" width="35">
                                    <img src="../images/checkout/mastercard.svg" onerror="this.src='../images/payment/mastercard.png'" width="35">
                                    <img src="../images/checkout/amex.svg" onerror="this.src='../images/payment/amex.png'" width="35">
                                    <img src="../images/checkout/discover.svg" onerror="this.src='../images/payment/discover.png'" width="35">
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group clearfix">
                                    <div class="col-xs-12 col-sm-9 xs-margin">
                                        <div class="group-card_number ">
                                            <div class="input-group">
                                                <input type="tel" class="-metrika-nokeys" id="card_number" name="number" maxlength="19" autocomplete="off">
                                                <label for="card_number">Card Number</label>
                                                <div class="cc-type">
                                                    <div></div>
                                                </div>
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-3 cvv-group mobile-clear">
                                        <div class="info-area">
                                            <span class="hidden-xs">
                                                <i class="fa fa-question-circle hidden-xs"></i>
                                            </span>
                                            <span class="visible-xs">
                                                <a href="#" title="Where find the CVV"  tabindex="-1" data-toggle="modal" data-target="#ccInfo">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                            </span>



                                        </div>
                                        <input type="tel" class="-metrika-nokeys" id="card_cvv" name="cvv" maxlength="4" autocomplete="off">
                                        <label for="card_cvv" title="Card Verification Value Code">CVV Code</label>
                                    </div>

                                    <div class="info-hint">
                                        <img src="../images/checkout/cvv.png" alt="">
                                    </div>


                                </div>


                                <div class="form-group clearfix">
                                    <div class="col-xs-5 col-sm-3">
                                        <!-- <input type="tel" class="-metrika-nokeys" id="card_expiry_month" name="expiry_month" placeholder="" maxlength="2" autocomplete="off"> -->
                                        <select class="-metrika-nokeys" id="card_expiry_month" name="expiry_month" autocomplete="off">
                                            <option value="">Month</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <!-- <label for="card_expiry_month" class="control-label">MM</label> -->
                                    </div>
                                    <div class="col-xs-7 col-sm-4">
                                        <!-- <input type="tel" class="-metrika-nokeys" id="card_expiry_year" name="expiry_year" placeholder="" maxlength="4" autocomplete="off"> -->
                                        <select name="expiry_year" class="-metrika-nokeys" id="card_expiry_year" name="expiry_year" autocomplete="off">
                                        <option value="">Year</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        </select>
                                        <!-- <label for="card_expiry_year" class="control-label">YYYY</label> -->
                                    </div>
                                    <div class="expiry_validation col-xs-12">
                                    </div>
                                </div>
                                <div class="row" style="display:none;">
                                    <div class="col-xs-12">
                                        <p class="payment-errors"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Pay Pal Panel-->
                        <div class="panel panel-default paypal-box inactive">
                            <div class="panel-heading clearfix">
                                <div class="no-gutter title-content title-content--payment col-xs-8 no-left">
                                    <h4>
                                        <i class="fa fa-circle-o"></i>

                                        <label for="paypal">
                                            <b class="fa-fw fa fa-paypal hidden-xs"></b>Paypal
                                        </label>
                                    </h4>
                                </div>
                                <div class="title-icons col-xs-4 text-right no-right">
                                    <img src="../images/checkout/paypal.svg" onerror="this.src='../images/payment/paypal.png'" width="85">
                                </div>
                            </div>
                        </div>
                        <!--END OF PAYMENT-->
                </div>
                <div class="form-group billing-section panel-block clearfix">
                    <!--BILLING-->
                    <div class="page-subtitle">
                        <h2>Billing Address</h2>
                    </div>
                    <!--Same as shipping-->
                    <div class="panel panel-default credit-card-box active">
                        <div class="panel-heading addres-heading clearfix">
                            <div class="title-content  col-xs-12 no-gutter">
                                <h4>
                                    <i class="fa fa-check-circle"></i>
                                   <label for="same_shipping">Same as shipping address <span>( {{ $cart['shipping_firstname'] }} {{ $cart['shipping_lastname'] }}, {{ $cart['shipping_address'] }} {{ @$cart['shipping_address2'] }}, {{ ucfirst($cart['shipping_city']) }}, {{ strtoupper($cart['shipping_state']) }} {{ $cart['shipping_zip' ] }} )</span> </label>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!--Different address-->
                    <div class="panel panel-default use-different--box inactive">
                        <div class="panel-heading addres-heading clearfix">
                            <div class="title-content col-xs-12 no-left">
                                <h4><i class="fa fa-circle-o"></i>
                                  <label for="use_different">Use a different billing address</label>
                               </h4>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="form-group clearfix">
                                <!-- Contact First  ame -->
                                <div class="col-xs-12 col-md-6 xs-margin">
                                    <input type="text" name="billing_firstname" id="billing_firstname" value="{{ old('billing_firstname') ? old('billing_firstname'):  $cart['shipping_firstname']  }}">
                                    <label for="billing_firstname">First Name </label>
                                </div>
                                <!-- Contact Last  ame -->
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" name="billing_lastname" id="contact_lastname" value="{{ old('billing_lastname') ? old('billing_lastname'): $cart['shipping_lastname'] }}">
                                    <label for="contact_lastname">Last Name</label>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <!-- Shipping Address Li e 1 -->
                                <div class="col-xs-12 col-md-8 xs-margin">
                                    <input type="text" name="billing_address" id="shipping_address" value="{{ old('billing_address') ?:  $cart['shipping_address'] }}">
                                    <label for="billing_address">Address</label>
                                </div>
                                <!-- Shipping Address Li e 2 -->
                                <div class=" col-xs-12 col-md-4">
                                    <input type="text" name="billing_address2" id="shipping_address2" value="{{ old('billing_address2') ?: $cart['shipping_address2'] }}">
                                    <label for="billing_address2">Address Line 2</label>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <!-- Shipping  ity -->
                                <div class=" col-xs-12">
                                    <input type="text" class="" name="billing_city" id="shipping_city" value="{{ old('billing_city') ?: $cart['shipping_city'] }}">
                                    <label for="billing_city">City </label>
                                </div>
                            </div>





                            <div class="form-group clearfix">
                                <!--Shipping Country-->
                                <div class="col-xs-12 col-md-4 xs-margin">
                                    <select class="" name="billing_country">
                                        @foreach($countries as $country) @if($country['code'] == (old('billing_country') ?: $cart['shipping_country']))
                                        <option value="{{ $country['code'] }}" selected>{{ $country['name'] }}</option>
                                        @else
                                        <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                                        @endif @endforeach
                                    </select>
                                </div>
                                <!-- Shipping S ate -->
                                <div class="col-xs-12 col-md-4 xs-margin">
                                    <input type="text" class="" name="billing_state" id="shipping_state" value="{{ old('billing_state') ? old('billing_state') : $cart['shipping_state'] }}">
                                    <label for="billing_state">State/Province</label>
                                </div>
                                <!-- Shipping Zip  ode -->
                                <div class="col-xs-12 col-md-4">
                                    <input type="text" class="" name="billing_zip" id="shipping_zip" value="{{ old('billing_zip') ? old('billing_zip'): $cart['shipping_zip'] }}">
                                    <label for="billing_zip">Zip/Postal Code</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                                    <div class="totals clearfix col-xs-12 col-md-6 pull-right">
                        <div class="totals-item">
                            <label>Subtotal</label>
                            <div class="totals-value" id="cart-subtotal">{{ $cart['sub_total'] }}</div>
                        </div>
                        @if($cart['tax'] > 0)
                        <div class="totals-item">
                            <!-- Tax only applied if shipping address in NJ -->
                            <label>Tax (7%)</label>
                            <div class="totals-value" id="cart-tax">{{ number_format($cart['tax'], 2) }}</div>
                        </div>
                        @endif
                        <div class="totals-item">
                            <label>Shipping</label>
                            <div class="totals-value" id="cart-shipping">{{ number_format($cart['shipping_fee'], 2) }}</div>
                        </div>
                        @if($cart['handling_fee'] > 0)
                        <div class="totals-item">
                            <!-- Handling Fee Adjustments -->
                            <label>Handling Fee</label>
                            <div class="totals-value" id="cart-tax">{{ number_format($cart['handling_fee'], 2) }}</div>
                        </div>
                        @endif
                        @if($cart['discount_total'] > 0)
                        <div class="totals-item" style=" padding-top: 5px; padding-bottom: 5px">
                            <label><span>Coupon</span></label>
                            <div class="totals-option">
                                <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
                                    <div class="coupon-discount">- $ {{ number_format($cart['discount_total'], 2) }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($creditApplied > 0.00)
                            <div class="totals-item" style=" padding-top: 5px; padding-bottom: 5px">
                                <label><span>Store Credit</span></label>
                                <div class="totals-option">
                                    <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
                                        <div class="coupon-discount">- $ {{ number_format($creditApplied, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($creditApplied > 0.00)
                            <div class="totals-item totals-item-total">
                                <label>Total</label>
                                <div class="totals-value" id="cart-total">{{ number_format($cart['total'] - $creditApplied, 2) }}</div>
                            </div>
                        @else
                            <div class="totals-item totals-item-total">
                                <label>Total</label>
                                <div class="totals-value" id="cart-total">{{ number_format($cart['total'], 2) }}</div>
                            </div>
                        @endif                       
                    </div>

                </div>
                @endif

                <div class="group action-buttons clearfix">
                    <div class="pull-left">
                        @if(Auth::check() && $storeCreditAmount > 0.00 && $creditApplied == 0.00)
                          <a href="#" id="redeem-store-credit">Redeem store credit : ${{ number_format($storeCreditAmount, 2) }}</a>
                        @elseif(Auth::check() && $storeCreditAmount > 0.00 && $creditApplied > 0.00 )
                          <a href="#" id="remove-store-credit">Remove store credit</a>
                        @endif
                        <a href="{{ url('cart/contact') }}" class="btn btn-transparent">
                            <span class="fa fa-fw fa-chevron-left"></span>
                            <span class="hidden-tablet">Contact Information</span>
                        </a>
                    </div>
                    <button id="btn_credit" type="submit" class="btn btn-submit btn-default pull-right">
                        Complete Order
                        <span class="fa fa-fw fa-chevron-right"></span>
                    </button>
                    <a href="{{ url('cart/paypal') }}" id="btn_paypal" class="load-hidden btn btn-submit btn-default pull-right">
                        Pay with PayPal
                        <span class="fa fa-fw fa-chevron-right"></span>
                    </a>
                </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade modal-login" id="ccInfo" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-top" style="border-radius: 8px;padding:10px 10px 30px 10px;">
                                    <button type="button" class="close" style="top:0;opacity: .4;    right: 12px;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" style="text-transform: none; margin: 35px 0 10PX;" id="modalLoginLabel">Where to find your CVV</h4>
                                    <div class="row">
                                        <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1">
                                             <div class="info-hint-retina">
                                                <img src="../images/checkout/cvv-retina.png" style="max-width:80%;" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

</div>

@stop @section('scripts')
<script type="text/javascript" src="{{ asset('js/libs/jquery.payment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pages/cart.js') }}"></script>
<script>
  (function (window, undefined) {

    var $ = window.jQuery || window.$ || {};
    var document = window.document;
    /////////////APPLY STORE CREDIT/////////////////////
    jQuery('#redeem-store-credit').on('click', function(){
        jQuery.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')}
        });
        jQuery.ajax({
             type: 'POST',
             url:  'payment/storecredit',
              data: {
                cart_id: {{ $cart['id'] }}, 
                credit_amount: {{ $storeCreditAmount }} 
            }
        })
        .done(function(data){
             if(data.success){
                window.location.href = "payment";
             }
        })
        .fail(function(error){
            console.log(error);
        });
    });

    jQuery('#remove-store-credit').on('click', function(){
        jQuery.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')}
        });
        jQuery.ajax({
             type: 'DELETE',
             url:  'payment/storecredit',
              data: {
                cart_id: {{ $cart['id'] }}, 
                credit_amount: {{ $creditApplied ? $creditApplied : 0.00 }} 
            }
        })
        .done(function(data){
             if(data.success){
                window.location.href = "payment";
             }
        })
        .fail(function(error){
            console.log(error);
        });
    });

    function onSubmitPayment (e) {
      var $this = $(this);
      $('.loadingoverlay').show();
      setTimeout(function () {
        $this.find('input, button, .btn').prop('disabled', true).attr('disabled', true).attr('onclick', 'return false;');
      }, 0);
    }

    var showInfo = function(){
        var infoEl = $('.info-area .hidden-xs');
        var hintEl = $('.info-hint');
        infoEl.on('click', function(){
            hintEl.show();
        });
        hintEl.on('mouseout', function(){
            hintEl.hide();
        })
        infoEl.on('mouseout', function(){
            hintEl.hide();
        })

    }

    var checkExpiration = function() {
        var month = $('#card_expiry_month');
        var year = $('#card_expiry_year');

        var currentYear = {{ $todaysYear }}
        var currentMonth =  {{ $todaysMonth }}

        var messageElement = $('.expiry_validation');
        var message = "Date shoud be greater than today"

        var checkBoth = function(){
            if (month.val() < currentMonth  && year.val() == currentYear ){
                messageElement.html(message).show();
                month.addClass('error');
                year.addClass('error');
            } else{
                messageElement.hide();
                month.removeClass('error');
                year.removeClass('error');
            }
        };


        month.on('change', function(){
            if (year.val() != "" ){
                checkBoth();
            }
        })
        year.on('change', function(){
            if (month.val() != ""){
                checkBoth();
            }
        })
    }

    $(document).ready(function () {
        showInfo();
        checkExpiration();
        $('form').on('submit', onSubmitPayment);
    });


  })(window);
</script>


@stop
