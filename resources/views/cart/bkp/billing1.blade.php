
@extends('cart.layout')

@section('content')
  <form class="form-horizontal" method="POST" role="form" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if($editing)
    <input type="hidden" name="editing" value="1">
    @endif
    <div class="page-title">
      @if(!$editing)
      <a href="{{ url('cart/contact') }}" onclick="javascript:document.forms[0]._prev.click();return false;" class="btn btn-default btn-nav-back">
        <span class="fa fa-fw fa-chevron-left"></span>
      </a>
      @endif
      <h1><span class="fa fa-fw fa-file-text-o card-icon"></span> Billing Details</h1>
      <div class="nav-dots">
        <span class="fa fa-fw fa-circle"></span>
        <span class="fa fa-fw fa-circle-o"></span>
        <span class="fa fa-fw fa-circle"></span>
        <span class="fa fa-fw fa-circle"></span>
      </div>
    </div>
    @if(isset($errors))
    <div class="alert alert-danger" role="alert">
      <strong>Error!</strong> The information provided is invalid. Please check to make sure you entered the right information.
    </div>
    @endif
    <div class="group">

      <!-- Billing Name -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('billing_name') ? 'has-error' : 'has-success' }} @endif">
        <label for="billing_name" class="col-sm-3 control-label">First &amp; Last Name<span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="billing_name" id="billing_name" value="{{ isset($input['billing_name']) ? $input['billing_name'] : $cart['billing_name'] }}" onfocus="this.select();" onmouseup="return false;" @if(empty($cart['billing_name']) || isset($errors) && $errors->has('billing_name')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('billing_name'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('billing_name') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Billing Address Line 1 -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('billing_address') ? 'has-error' : 'has-success' }} @endif">
        <label for="billing_address" class="col-sm-3 control-label">Address <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="billing_address" id="billing_address" value="{{ isset($input['billing_address']) ? $input['billing_address'] : $cart['billing_address'] }}" onfocus="this.select();" onmouseup="return false;" @if(empty($cart['billing_address']) || isset($errors) && $errors->has('billing_address')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('billing_address'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('billing_address') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Billing Address Line 2 -->
      <div class="form-group">
        <label for="billing_address" class="col-sm-3 control-label">Address Line 2 <span class="required-field">&nbsp;</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="billing_address2" id="billing_address2" value="{{ isset($input['billing_address2']) ? $input['billing_address2'] : $cart['billing_address2'] }}" onfocus="this.select();" onmouseup="return false;">
        </div>
      </div>

      <!-- Billing Country -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('billing_country') ? 'has-error' : 'has-success' }} @endif">
        <label for="billing_country" class="col-sm-3 control-label">Country <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <select class="custom-select form-control" name="billing_country" id="billing_country" @if(empty($cart['billing_country']) || isset($errors) && $errors->has('billing_country')) autofocus @endif>
            <option value="">- Select country -</option>
            @foreach($countries as $country)
            <option value="{{ $country['code'] }}" {{ ($country['code'] == (empty($cart['billing_country']) ? 'US' : $cart['billing_country'])) ? 'selected' : '' }}>{{ $country['name'] }}</option>
            @endforeach
          </select>
          @if(isset($errors) && count($errors))
          @if($errors->has('billing_country'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: 2em"></span>
          @foreach($errors->get('billing_country') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="right: 2em"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Billing State -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('billing_state') ? 'has-error' : 'has-success' }} @endif">
        <label for="billing_state" class="col-sm-3 control-label">State/Province <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="billing_state" id="billing_state" value="{{ isset($input['billing_state']) ? $input['billing_state'] : $cart['billing_state'] }}" onfocus="this.select();" onmouseup="return false;"@if(empty($cart['billing_state']) || isset($errors) && $errors->has('billing_state')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('billing_state'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('billing_state') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Billing City -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('billing_city') ? 'has-error' : 'has-success' }} @endif">
        <label for="billing_city" class="col-sm-3 control-label">City <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="billing_city" id="billing_city" value="{{ isset($input['billing_city']) ? $input['billing_city'] : $cart['billing_city'] }}" onfocus="this.select();" onmouseup="return false;" @if(empty($cart['billing_city']) || isset($errors) && $errors->has('billing_city')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('billing_city'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('billing_city') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Billing Zip code -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('billing_zip') ? 'has-error' : 'has-success' }} @endif">
        <label for="billing_zip" class="col-sm-3 control-label">Zip/Postal Code <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="billing_zip" id="billing_zip" value="{{ isset($input['billing_zip']) ? $input['billing_zip'] : $cart['billing_zip'] }}" onfocus="this.select();" onmouseup="return false;" @if(empty($cart['billing_zip']) || isset($errors) && $errors->has('billing_zip')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('billing_zip'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('billing_zip') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

    </div>

    <div class="group action-buttons">
      @if($editing)
      <div class="pull-right">
        <button type="submit" name="_next" value="payment" class="btn btn-primary">
          <span class="fa fa-check-square-o fa-fw fa-lg"></span>
          <span>
            Review &amp; Pay
          </span>
          <span class="fa fa-fw fa-chevron-right"></span>
        </button>
      </div>
      @else
      <div class="pull-right text-center">
        <button type="submit" name="_next" value="shipping" class="btn btn-primary">
          <span class="fa fa-truck fa-fw fa-lg"></span>
          <span>
            Shipping Details
          </span>
          <span class="fa fa-fw fa-chevron-right"></span>
        </button>
      </div>
      <div class="pull-left">
        <button type="submit" name="_prev" value="contact" class="btn btn-default visible-lg">
          <span class="fa fa-fw fa-chevron-left"></span>
          <span class="">Contact Details</span>
        </button>
      </div>
      @endif
    </div>

  </form>
@stop

@section('scripts')
<script>
  (function (window, undefined) {
    var $ = window.jQuery || window.$ || {};
    var document = window.document;

    function onSubmitPayment (e) {
      var $this = $(this);
      setTimeout(function () {
        $this.find('[name="number"], [name="cvv"]').attr('type', 'password');
        $this.find('input, button, .btn').prop('disabled', true).attr('disabled', true).attr('onclick', 'return false;');
      }, 0);
    }

    $(document).ready(function () {
      $('form').on('submit', onSubmitPayment);
    });
  })(window);
</script>
@stop