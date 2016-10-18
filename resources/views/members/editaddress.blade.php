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
                <h4>edit address</h4>
            </header>
            <div class="editor-main no-height">
                <div class="title-area">
                    <a href="#" class="btn pull-right btn-add">Add New Address &nbsp;<i class="fa fa-plus-circle"></i></a>
                    <strong class="title">Address</strong>
                </div>
                <div class="alert alert-danger error-list" role="alert" style="display: none"></div>
                <div class="alert alert-success success-message" role="alert" style="display: none"></div>
                <form action="#" class="vip-form">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" placeholder="Street Address" value="{{ $currentAddress->address_street }}" id="address_street">
                    </div>
                    <div class="form-group">
                        <label>Apt. / Unit / Suite</label>
                        <input type="text" placeholder="Apt. / Unit / Suite" value="{{ $currentAddress->address_street2 }}" id="address_street2">
                    </div>
                     <div class="form-group">
                        <label>Country</label>
                        <div class="select-input">
                            @if(empty($currentAddress->address_country_code))
                                <select name="shipping_country" id="shipping_country" class="crs-country address_country_name" data-region-id="shipping_state" data-default-value="US" data-value="shortcode"></select>
                            @elseif (!empty($currentAddress->address_country_code))
                                <select name="shipping_country" id="shipping_country" class="crs-country address_country_name" data-region-id="shipping_state" data-value="shortcode" data-default-value="{{ $currentAddress->address_country_name }}">
                                 @foreach($countries as $country)
                                    @if(!empty($currentAddress->address_country_code) && $currentAddress->address_country_code == $country['code'])
                                        <option value="{{ $country['code'] }}"  selected>{{ $country['name'] }}</option>
                                    @elseif(empty($currentAddress->address_country_code) && $country['code'] == 'US')
                                        <option value="{{ $country['code'] }}"  selected>{{ $country['name'] }}</option>
                                    @else
                                        <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                                    @endif
                                @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label>State</label>                        
                            @if ($currentAddress->address_state)
                                <label for="shipping_state">State</label>
                                <input type="text" name="shipping_state" id="shipping_state" class="has-state address_state" value="{{ $currentAddress->address_state }}">
                            @else
                                <select name="shipping_state" id="shipping_state" class="shipping_dropdown address_state" ></select>
                            @endif
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" placeholder="City" value="{{ $currentAddress->address_city }}" id="address_city">
                    </div>
                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" placeholder="Zip Code" value="{{ $currentAddress->address_zip }}" id="address_zip">
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
                    type: 'PATCH',
                    url: '/members/address/{{ $currentAddress->id }}/update',
                    data: payload
                })
                .done(function(data){
                    if(data.success){
                        console.log('success');
                         $('.error-list').hide();
                        $('.success-message').html('<p><strong>Success!</strong> Address updated.</p>').show();                        
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