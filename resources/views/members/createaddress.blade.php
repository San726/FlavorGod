@extends('app')
@section('content')
<header class="profile-header">
        <div class="profile-links">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Profile</a></li>
                    <li class="active"><a href="#">Edit Profile</a></li>
                </ol>
                <a href="/auth/logout" class="logout">logout <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
        <div class="tabs-box">
            <div class="container">
                <ul class="profile-tab">
                    <li class="active"><a href="/members/profile">profile</a></li>
                    <li><a href="/members/orders">my orders</a></li>
                    <li><a href="/members/referralprogram">refer-a-friend</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container main-container-wrap">
        <div class="profile-editor">
            <header class="editor-header">
                <h4>new address</h4>
            </header>
            <div class="editor-main no-height">
                <div class="title-area">
                    <strong class="title">Address</strong>
                </div>
                <div class="alert alert-danger error-list" role="alert" style="display: none"></div>
                <div class="alert alert-success success-message" role="alert" style="display: none"></div>
                <form action="#" class="vip-form">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" placeholder="Street Address" id="address_street">
                    </div>
                    <div class="form-group">
                        <label>Apt. / Unit / Suite</label>
                        <input type="text" placeholder="Apt. / Unit / Suite" id="address_street2">
                    </div>
                     <div class="form-group">
                        <label>Country</label>
                        <div class="select-input">
                            <select name="shipping_country" id="shipping_country" class="crs-country address_country_name" data-region-id="shipping_state" data-default-value="US" data-value="shortcode">
                                @foreach($countries as $country)
                                    @if($country['code'] == 'US')
                                        <option value="{{ $country['code'] }}" selected>{{ $country['name'] }}</option>
                                    @else
                                        <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                                    @endif                                
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>State</label>                        
                            <select name="shipping_state" id="shipping_state" class="shipping_dropdown address_state" ></select>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" placeholder="City" id="address_city">
                    </div>
                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" placeholder="Zip Code" id="address_zip">
                    </div>
                </form>
            </div>
            <div class="editor-buttons">
                <a href="/members/profile" class="btn-left btn btn-profile"><i class="fa fa-angle-left"></i> PROFILE</a>
                <button class="btn btn-right btn-save">SAVE</button>
            </div>
        </div>
    </div>
@stop
@section('scripts')
<script type="text/javascript" src="{{ asset('js/libs/jquery.crs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/libs/jquery.country-phone.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/libs/jquery.payment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pages/cart.js') }}"></script>

<script>
// get the  data from the plugin
var countryData = $.fn.intlTelInput.getCountryData(),  addressDropdown = $("#shipping_country");
// init plugin
telInput.intlTelInput({
      utilsScript: "{{ asset('js/libs/crs-utils.js') }}"
});
// populate the country dropdown
$.each(countryData, function(i, country) {
  addressDropdown.append($("<option></option>").attr("value", country.iso2).text(country.name));
});

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

@section('addressedit.script')
    <script>
        (function(){
            $('.btn-save').on('click', function(){
                var payload = {};
                payload.address_street = $('#address_street').val();
                payload.address_street2 = $('#address_street2').val();
                payload.address_country_name = $('.address_country_name').val();
                payload.address_state = $('.address_state').val();
                payload.address_city = $('#address_city').val();
                payload.address_zip = $('#address_zip').val();
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')} 
                });
                $.ajax({
                    type: 'POST',
                    url: '/members/address/store',
                    data: payload
                })
                .done(function(data){
                    if(data.success){
                         $('.error-list').hide();
                       $('#address_street').val('');
                       $('#address_street2').val('');
                       $('.address_country_name').val('');
                       $('.address_state').val('');
                       $('#address_city').val('');
                        $('#address_zip').val('');
                        $('.success-message').html('<p><strong>Success!</strong> Address created.</p>').show();                        
                    }
                })
                .fail(function(error){
                    console.log('error');
                    var error = JSON.parse(error.responseText);
                    if(error.errors.length){
                            var errorList = '<ul>';
                            $.each(error.errors, function(i, val){
                                errorList += '<li>' + val + '</li>';
                            });
                            errorList += '</ul>';
                            $('.success-message').hide();
                            $('.error-list').html(errorList).show();                        
                    }
                });        
                return;
            }); 
        })();
    </script>


@stop