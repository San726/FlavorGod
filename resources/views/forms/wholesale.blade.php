@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

<?php $titleClass = "wholesale-title" ?>

@section('title', 'Wholesale')
@section('description', 'Flavorgod Wholesale Form - Become a Flavorgod reseller today!')
@section('keywords', 'flavorgod, wholesale, reseller, resale flavorgod')
@section('content')
    <div class="vip-list-section section">
        <div class="container">
            {{-- vip list code here --}}
            <div class="top-media-box">
                <div class="vip-section-inner full-width">
                    <div class="media">
                        <div class="media-left media-middle">
                            <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/4386f07d95291d55603677c8304926d8b6d798ee.png" alt="wholesale page img">
                        </div>
                        <div class="media-body">
                            <h2>FLAVORGOD WHOLESALE</h2>
                            <p>When I first created Flavor God Seasonings in December of 2012, my goal was to <b>offer healthy seasonings</b> - unlike anything sold in stores - by using fresh herbs & spices. <i>My blends use real ingredients, minimal amounts of sea salt, and never have added chemicals or fillers.</i> I created Flavor God Seasonings with the principle of respecting ingredients, as they exist in nature while creating balanced flavors with all-purpose applications. My goal is to simply craft the best seasonings available on the market while making the art of cooking fun for anyone who uses my products.</p>
                            <p>After upgrading the size of my business operation yet again, I'm very excited to reveal that we are now open for <b>retail distribution</b> worldwide. We want to partner with the best privately owned walk-in stores, national franchises, and international distributors who want to carry my Flavor God brand alongside their own.</p>
                            <p><b>Thank you</b> for your interest in carrying Flavor God! <br/><i>I look forward to working with you.</i></p>
                            <p><img style="float:left;" src="{{ url('images/chriswallace-signature.png') }}" alt=""/></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sec-learn hidden-xs" style="height:300px;">
        <div class="dis-table">
            <div class="dis-table-cell">
                <div class="container">
                    <h2 style="font-size:32px"><strong>Register</strong> Your Business Today</h2>
                </div>
            </div>
        </div>
        <div class="side-img side-right" style="position: relative; float: right; margin-top:-200px" >
            <img src="{{ url('images/img-learn-right.png') }}" alt=""/>
        </div>
    </div>
    <div class="wholesale-section wholesale-bottom">
        <div class="container wholesale-form">
            <div class="white-bg vip-form-holder small-top-border" id="form_error">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="wholesale-inner full-width">
                    <form action="" class="vip-form" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="fieldset">
                            <strong class="title">Personal Information</strong>
                            <div class="form-group">
                                <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <input style="padding-left:48px;" type="tel" name="contact_phone" id="contact_phone" placeholder="Contact Phone" value="{{ old('contact_phone') }}">
                                <label id="label_phone" class="floating" for="contact_phone">Phone Number (optional) </label>
                            </div>
<!--                             <div class="form-group visible-xs">
                                <div class="select-input">
                                    <select name="gender" >
                                        <option>Gender</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>

                        <div class="fieldset">
                            <strong class="title">Address Information</strong>
                            <div class="form-group">
                                <input type="text" name="address_line1" placeholder="Address Line 1" value="{{ old('address_line1') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="address_line2" placeholder="Address Line 2" value="{{ old('address_line2') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="address_city" placeholder="City" value="{{ old('address_city') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="address_state" placeholder="State/Region" value="{{ old('shipping_state') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="address_country" placeholder="Country" value="{{ old('shipping_country') }}">
                            </div>
<!--                             <div class="form-group">
                                <div class="select-input">
                                    <select name="address_state" id="shipping_state" class="shipping_dropdown" >
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="select-input">
                                    <select disabled name="address_country" id="shipping_country" class="crs-country" data-region-id="shipping_state" data-default-value="US" data-value="shortcode" >
                                    </select>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <input type="text" name="address_zipcode" placeholder="Zip Code" value="{{ old('address_zipcode') }}">
                            </div>
<!--                             <div class="form-group visible-xs">
                                <div class="select-input" name="address_timezone">
                                    <select>
                                        <option>Time Zone</option>
                                        <option>Zone 1</option>
                                        <option>Zone 2</option>
                                        <option>Zone 3</option>
                                        <option>Zone 4</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>

                        <div class="fieldset no-padding">
                            <div class="checkbox-group">
                                <span>Where are you going to sell my seasonings?</span>
                                <div class="labels" style="margin-top:20px;">
                                    <label class="radioitem">
                                        <input type="checkbox" name="where_to_sell[]" value="physical_store">
                                        Physical Store
                                    </label>
                                    <label class="radioitem">
                                        <input type="checkbox" name="where_to_sell[]" value="website">
                                        On my website
                                    </label>
                                    <label class="radioitem">
                                        <input type="checkbox" name="where_to_sell[]" value="other">
                                        Other
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" style="display:none;">
                                <textarea name="other_place_to_sell" placeholder="Please explain..." style="resize:none;min-height: 100px;"></textarea>
                            </div>
                            <div class="submit-box">
                                <div class="left-box">
                                    <label class="checkboxitem">
                                        <input type="checkbox" name="newsletter" value="1">
                                        Subscribe to the FLAVORGOD Newsletter
                                    </label>
                                </div>
                            </div>
                            <div class="submit-box">
                                <div class="g-recaptcha" data-sitekey="{{ Config::get('recaptcha.sitekey') }}"></div>
                                <div class="submit-field">
                                    <input type="submit" class="btn btn-default btn-block" value="SIGN UP">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="{{ asset('js/libs/jquery.crs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/libs/jquery.country-phone.js') }}"></script>

<script>
$('input[value="other"]').change(function(){
    if($('input[value="other"]').is(':checked')){
       $('textarea[name="other_place_to_sell"').closest('.form-group').slideDown();
    }
    else{
       $('textarea[name="other_place_to_sell"').closest('.form-group').slideUp();
    }
});

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
  // console.log(countryCode)
}).bind();



    //Check if shipping_state has data, if not add a class to run the states dropdown
    $(document).ready(function() {

        telInput.change();
        addressDropdown.change();

    });
</script>
@stop
