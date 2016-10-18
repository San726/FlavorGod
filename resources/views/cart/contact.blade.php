@extends('cart.layout')
@section('content')
<!---------------------------------------------------------------------------- [1] Contact ------------------------------------------------------------------------------>

<div class="cart-page">
    <div class="cart-payment cart-page" style="margin-bottom:0 !important; padding-bottom: 0 !important;" >
        <div class="container  order-summary">

        <div class="section row">
            <div class="order-summary--header col-xs-12">
                <div class="pull-left">
                    <h2><b class="fa fa-fw fa-shopping-cart"></b>Show order summary <b class="fa fa-chevron-down"></b></h2>
                </div>
                <div class="pull-right hidden-xs">
                    <h2 class="total">$ {{ number_format($cart['total'], 2) }}</h2>
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
                        <form method="POST" role="form" id="form-cart">
                            <input type="hidden" name="_token" value="m19IDDMhPRO2ZqXGY6eZI5Wzh6rmsxmwNDqyv4uc">
                            <div class="totals-item" style=" padding-top: 5px; padding-bottom: 5px">
                                <label><span>Coupon</span></label>
                                <div class="totals-option">
                                    <div class="input-group input-group-sm pull-right" style="margin-left: 10px; max-width: 128px">
                                        <div class="coupon-discount">- $ {{ number_format($cart['discount_total'], 2) }}</div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                        <div class="totals-item totals-item-total">
                            <label>Total</label>
                            <div class="totals-value" id="cart-total">{{ number_format($cart['total'], 2) }}</div>
                        </div>
                    </div>

                    <!--END OF TOTALS-->


                    <!--End of Static summary for design development-->


                </div>

            </div>

        </div>
    </div>
    </div>

    <div class="container cart-container">

        @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            @foreach ($errors as $field => $messages)
            <h4>{{ $field }}</h4>
            <ul>
                @foreach($messages as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
            @endforeach
        </div>
        @endif
        <form class=" form-horizontal" method="POST" role="form" action="{{ url('/cart/contact') }}" novalidate>

            <div class="section contact-section">
                {!! csrf_field() !!}
            <div class="page-subtitle">
                <h2>
                 <b class="fa fa-fw fa-user"></b>
             Customer Information</h2>
            </div>
            <div class="block-group clearfix ">
                <!-- Contact E ail -->
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="email" name="contact_email" id="contact_email" value="{{ $cart['contact_email'] ? $cart['contact_email'] : old('contact_email') }}">
                        <label for="contact_email" class="">Email</label>
                    </div>
                    @if(!$user)
                        <div class="col-xs-12 box-login">
                            Already have an account with us?
                            <a href="#" title="LOGIN"  tabindex="-1" data-toggle="modal" data-target="#modalLogin" class="btn-login auth-link">Log in</a>
                        </div>
                    @endif
                </div>

<!--                 <div class="form-group instagram-group">
                        <div class="tip-message col-xs-12">
                            Enter Instagram Username to qualify for monthly giveaway!
                        </div>
                    <div class="col-xs-12 input-group">
                        <span class="input-group-addon" id="sizing-addon1">
                            <i class="fa fa-instagram" style="color: #616161;opacity: .7;"></i>
                        </span>
                        <input type="text" name="contact_handle" id="contact_instagram" value="{{ $cart['contact_handle'] ? $cart['contact_handle']: old('contact_handle') }}">
                        <label for="contact_instagram" class="">Instagram Username  (optional)</label>
                    </div>
                </div> -->

            </div>


            <!---------------------------------------------------------------------------- [2] Shipping ------------------------------------------------------------------------------>




            <div class="page-subtitle">
                <h2>
              <b class="fa fa-fw fa-truck fa-flip-horizontal"></b>
              Shipping Address</h2>
            </div>

            <div class="form-group clearfix">
                <!-- Shipping First  Name -->
                <div class="col-xs-12 col-md-6 xs-margin">
                    <input type="text" name="shipping_firstname" id="shipping_firstname" value="{{ $cart['shipping_firstname'] ? $cart['shipping_firstname']: old('shipping_firstname') }}">
                    <label for="shipping_firstname">First Name </label>
                </div>
                <!-- Shipping Last  Name -->
                <div class="col-xs-12 col-md-6">
                    <input type="text" name="shipping_lastname" id="shipping_lastname" value="{{ $cart['shipping_lastname'] ?$cart['shipping_lastname']: old('shipping_lastname') }}">
                    <label for="shipping_lastname">Last Name</label>
                </div>
            </div>

            <div class="form-group clearfix">
                <!-- Shipping Address Line 1 -->
                <div class="col-xs-12 col-md-8 xs-margin">
                    <input type="text" name="shipping_address" id="shipping_address" value="{{ $cart['shipping_address'] ? $cart['shipping_address']: old('shipping_address' ) }}">
                    <label for="shipping_address">Address</label>
                </div>

                <!-- Shipping Address Line 2 -->
                <div class=" col-xs-12 col-md-4">
                    <input type="text" name="shipping_address2" id="shipping_address2" value="{{ $cart['shipping_address2']? $cart['shipping_address2']: old('shipping_address2') }}">
                    <label for="shipping_address2">Address Line 2</label>
                </div>
            </div>

            <div class="form-group clearfix">
                <!--Shipping Country-->
                <div class="col-xs-12 col-md-4 xs-margin">

                    @if (empty($cart['shipping_country']))
                    <select name="shipping_country" id="shipping_country" class="crs-country" data-region-id="shipping_state" data-default-value="US" data-value="shortcode"></select>
                    @elseif (!empty($cart['shipping_country']))
                    <select name="shipping_country" id="shipping_country" class="crs-country" data-region-id="shipping_state" data-value="shortcode" data-default-value="{{ $cart['shipping_country']? $cart['shipping_country']: old('shipping_country') }}">
                    @foreach($countries as $country)
                        @if(!empty($cart['shipping_country']) && $cart['shipping_country'] == $country['code'])
                            <option value="{{ $country['code'] }}"  selected>{{ $country['name'] }}</option>
                        @elseif(empty($cart['shipping_country']) && $country['code'] == 'US')
                            <option value="{{ $country['code'] }}"  selected>{{ $country['name'] }}</option>
                        @else
                            <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                        @endif
                    @endforeach
                    </select>
                    @endif

                </div>
                <!-- Shipping State -->
                <!-- show if (Canada || US) -->
                <div class="col-xs-12 col-md-4 xs-margin">
                    <!-- <input type="text" class="" name="shipping_state" id="shipping_state" value="{{ $cart['shipping_state' ] ? $cart['shipping_state']: old('shipping_state') }}"> -->
                    @if ($cart['shipping_state'])
                        <input type="text" name="shipping_state" id="shipping_state" class="has-state" value="{{ $cart['shipping_state' ] ? $cart['shipping_state']: old('shipping_state') }}">
                        <label for="shipping_state">State/Province</label>
                    @else
                        <select name="shipping_state" id="shipping_state" class="shipping_dropdown" ></select>
                    @endif
                </div>
                <!-- Shipping Zip Code -->
                <div class="col-xs-12 col-md-4">
                    <input type="text" class="" name="shipping_zip" id="shipping_zip" value="{{ $cart['shipping_zip'] ? $cart['shipping_zip'] : old('shipping_zip') }}">
                    <label id="label_zip" for="shipping_zip">Zip/Postal Code</label>
                </div>

            </div>


             <div class="form-group">
                <!-- Shipping  City -->
                <div class=" col-xs-12 col-md-6 xs-margin">
                    <input type="text" class="" name="shipping_city" id="shipping_city" value="{{ $cart['shipping_city'] ? $cart['shipping_city']: old('shipping_city') }}">
                    <label for="shipping_city">City </label>
                </div>
                <!-- Phone Number -->
                <div class=" col-xs-12 col-md-6">
                    <input type="tel" id="contact_phone" name="contact_phone" value="{{ $cart['contact_phone'] ? $cart['contact_phone']: old('contact_phone') }}">
                    <label id="label_phone" class="floating" for="contact_phone">Phone Number (optional) </label>
                    <p class="phone_disclaimer"> Please enter your phone number for information about this order.</p>
                </div>
                <!-- Handling Fee -->
                <div class="col-xs-12">

                   <div class="checkbox" id="expedite">
                        <label>
                          <input type="checkbox" name="expedite"
                            @if($cart['handling_fee'] > 0)
                               checked
                            @endif
                          > I want Expedited Rush Handling for $7.95
                        </label>
                   </div>

                </div>

            </div>


            </div>

                <div class="group action-buttons clearfix">
                    <button type="submit" name="_next" value="payment" class="btn btn-default paypal-box pull-right">
                        Continue to Payment
                        <span class="fa fa-fw fa-chevron-right"></span>
                    </button>
                    <div class="pull-left">
                        <button type="submit" name="_prev" value="cart" class="btn btn-transparent">
                            <span class="fa fa-fw fa-chevron-left"></span>
                            <span class="hidden-tablet">Edit Cart</span>
                        </button>
                    </div>
                </div>
        </form>
    </div>
</div>


<!---------------------------------------------------------------------------- [3] Payment ------------------------------------------------------------------------------>
@stop

@section('libs')

@stop

@section('scripts')

<script>
        //Checking if the form has a saved shipping_state, if so remove the crs-country to not run the state dropdown
        if($('.has-state')[0]){
            $('#shipping_country').removeClass('crs-country')
        }
</script>

<script type="text/javascript" src="{{ asset('js/libs/jquery.crs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/libs/jquery.country-phone.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/libs/jquery.payment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pages/cart.js') }}"></script>

<script>


// get the  data from the plugin
var countryData = $.fn.intlTelInput.getCountryData(),
  telInput = $("#contact_phone"),
  addressDropdown = $("#shipping_country");

// init plugin
telInput.intlTelInput({
      utilsScript: "{{ asset('js/libs/crs-utils.js') }}"
});

// populate the country dropdown
$.each(countryData, function(i, country) {
  addressDropdown.append($("<option></option>").attr("value", country.iso2).text(country.name));
});

// // listen to the telephone input for changes
// telInput.change(function() {
//   var countryCode = telInput.intlTelInput("getSelectedCountryData").iso2;
//   addressDropdown.val(countryCode);
// });

// trigger a fake "change" event now, to trigger an initial sync
telInput.change();

// listen to the address dropdown for changes
addressDropdown.change(function() {
  var countryCode = $(this).val();
  telInput.intlTelInput("setCountry", countryCode);
  console.log(countryCode)
}).bind();



    //Check if shipping_state has data, if not add a class to run the states dropdown
    $(document).ready(function() {

        telInput.change();
        addressDropdown.change();

    });
</script>

@if(App::environment('production'))
<script>
    fbq('track', 'InitiateCheckout');
</script>
@endif

@stop
