@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

<?php $titleClass = "viplist-title" ?>

@section('title', 'Vip List')
@section('description', 'Find out how its possible to Paleo Seasoning, GMO Free, MSG Free and delicious flavoring all packed in one bottle!')
@section('keywords', 'paleo, msg free, seasoning, who is chris wallace, chris wallace, healthy seasonings')
@section('content')
    <div class="vip-list-section section">
        <div class="container">
            {{-- vip list code here --}}
            <div class="top-media-box">
                <div class="vip-section-inner full-width">
                    <div class="media">
                        <div class="media-left media-middle">
                            <img src="{{ asset('images/vip-page01.png') }}" alt="vip page img">
                        </div>
                        <div class="media-body">
                            <h4>FLAVORGOD VIP Product Rate &amp; Review Program</h4>
                            <p>Do you have a knack for knowing what will make your food taste bangin'? Are you a food fanatic? A seasoning wizard? Picky about flavor? Do you like free stuff?</p>
                            <p class="bold">If you said YES, YES, YES, YES, and YES…. then apply to become a Flavor God Gourmet VIP!</p>
                            <p class="no-margin-small">If you’re chosen to be a VIP, we’ll send you free samples of different varieties Flavor God, you do your food magic with our awesome seasonings and tell us what you like, what you don’t like, and why. What a deal! All you need to do is fill out the form below.</p>
                            <p class="bold">(Hurry up, though, we only need a few spice gurus at this time!)</p>
                            <p>You must be a US resident and 18 years or older to participate.</p>
                        </div>
                    </div>
                </div>
            </div>
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

                <div class="vip-section-inner full-width">
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
                            </div>
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
                                <span>Do you have an Amazon account?</span>
                                <div class="labels">
                                    <label class="radioitem">
                                        <input type="radio" name="amazon-account" value="1">
                                        Yes
                                    </label>
                                    <label class="radioitem">
                                        <input type="radio" name="amazon-account" value="0">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="checkbox-group">
                                <span>Do you have an You Tube account?</span>
                                <div class="labels">
                                    <label class="radioitem">
                                        <input type="radio" name="youtube-account" value="1">
                                        Yes
                                    </label>
                                    <label class="radioitem">
                                        <input type="radio" name="youtube-account" value="0">
                                        No
                                    </label>
                                </div>
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
@stop
