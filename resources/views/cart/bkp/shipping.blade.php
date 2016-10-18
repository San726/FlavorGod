@extends('cart.layout')

@section('content')
  <form class="form-horizontal" method="POST" role="form" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if($editing)
    <input type="hidden" name="editing" value="1">
    @endif
    <div class="page-title">
      @if(!$editing)
      <a href="{{ url('cart/billing') }}" onclick="javascript:document.forms[0]._prev.click();return false;" class="btn btn-default btn-nav-back">
        <span class="fa fa-fw fa-chevron-left"></span>
      </a>
      @endif
      <h1><span class="fa fa-fw fa-truck card-icon"></span> Shipping Details</h1>
      <div class="nav-dots">
        @if($cart['status'] == 0)
        <span class="fa fa-fw fa-circle"></span>
        @endif
        <span class="fa fa-fw fa-circle"></span>
        <span class="fa fa-fw fa-circle-o"></span>
        <span class="fa fa-fw fa-circle"></span>
      </div>
    </div>
    @if(isset($errors))
    <div class="alert alert-danger" role="alert">
      <strong>Error!</strong> The information provided is invalid. Please check to make sure you entered the right information.
    </div>
    @endif
    <div class="group">

      <!-- Shipping Name -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('shipping_name') ? 'has-error' : 'has-success' }} @endif">
        <label for="shipping_name" class="col-sm-3 control-label">First &amp; Last Name<span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="shipping_name" id="shipping_name" value="{{ isset($input['shipping_name']) ? $input['shipping_name'] : $cart['shipping_name'] }}" onfocus="this.select();" onmouseup="return false;" @if(isset($errors) && $errors->has('shipping_name')) autofocus @endif>
           @if(isset($errors) && count($errors))
          @if($errors->has('shipping_name'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('shipping_name') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Shipping Address Line 1 -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('shipping_address') ? 'has-error' : 'has-success' }} @endif">
        <label for="shipping_address" class="col-sm-3 control-label">Address <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="shipping_address" id="shipping_address" value="{{ isset($input['shipping_address']) ? $input['shipping_address'] : $cart['shipping_address'] }}" onfocus="this.select();" onmouseup="return false;" @if(isset($errors) && $errors->has('shipping_address')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('shipping_address'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('shipping_address') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Shipping Address Line 2 -->
      <div class="form-group">
        <label for="shipping_address" class="col-sm-3 control-label">Address Line 2 <span class="required-field">&nbsp;</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="shipping_address2" id="shipping_address2" value="{{ isset($input['shipping_address2']) ? $input['shipping_address2'] : $cart['shipping_address2'] }}" onfocus="this.select();" onmouseup="return false;">
        </div>
      </div>

      <!-- Shipping Country -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('shipping_country') ? 'has-error' : 'has-success' }} @endif">
        <label for="shipping_country" class="col-sm-3 control-label">Country <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <select class="custom-select form-control" name="shipping_country" id="shipping_country" @if(isset($errors) && $errors->has('shipping_country')) autofocus @endif>
            <option value="">- Select country -</option>
            @foreach($countries as $country)
            <option value="{{ $country['code'] }}" {{ ($country['code'] == (empty($cart['shipping_country']) ? 'US' : $cart['shipping_country'])) ? 'selected' : '' }}>{{ $country['name'] }}</option>
            @endforeach
          </select>
          @if(isset($errors) && count($errors))
          @if($errors->has('shipping_country'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: 2em"></span>
          @foreach($errors->get('shipping_country') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="right: 2em"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Shipping State -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('shipping_state') ? 'has-error' : 'has-success' }} @endif">
        <label for="shipping_state" class="col-sm-3 control-label">State/Province <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="shipping_state" id="shipping_state" value="{{ isset($input['shipping_state']) ? $input['shipping_state'] : $cart['shipping_state'] }}" onfocus="this.select();" onmouseup="return false;" @if(isset($errors) && $errors->has('shipping_state')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('shipping_state'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('shipping_state') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Shipping City -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('shipping_city') ? 'has-error' : 'has-success' }} @endif">
        <label for="shipping_city" class="col-sm-3 control-label">City <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="shipping_city" id="shipping_city" value="{{ isset($input['shipping_city']) ? $input['shipping_city'] : $cart['shipping_city'] }}" onfocus="this.select();" onmouseup="return false;" @if(isset($errors) && $errors->has('shipping_city')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('shipping_city'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('shipping_city') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Shipping Zip code -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('shipping_zip') ? 'has-error' : 'has-success' }} @endif">
        <label for="shipping_zip" class="col-sm-3 control-label">Zip/Postal Code <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="shipping_zip" id="shipping_zip" value="{{ isset($input['shipping_zip']) ? $input['shipping_zip'] : $cart['shipping_zip'] }}" onfocus="this.select();" onmouseup="return false;" @if(isset($errors) && $errors->has('shipping_zip')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('shipping_zip'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('shipping_zip') as $error)
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
        @if($cart['status'] == 1)
        <button type="submit" name="_next" value="payment" class="btn btn-default btn-checkout btn-paypal">
          <span class="paypal">
            <span class="pay"></span>
            <span class="pal"></span>
          </span>
          <span>
            Review &amp; Pay
          </span>
          <span class="fa fa-fw fa-chevron-right"></span>
        </button>
        @else
        <button type="submit" name="_next" value="payment" class="btn btn-primary">
          <span class="fa fa-check-square-o fa-fw fa-lg"></span>
          <span>
            Review &amp; Pay
          </span>
          <span class="fa fa-fw fa-chevron-right"></span>
        </button>
        @endif
      </div>
      @else
      <div class="pull-right text-center">
        <button type="submit" name="_next" value="payment" class="btn btn-primary">
          <span class="fa fa-check-square-o fa-fw fa-lg"></span>
          <span>
            Review &amp; Pay
          </span>
          <span class="fa fa-fw fa-chevron-right"></span>
        </button>
      </div>
      <div class="pull-left">
        <button type="submit" name="_prev" value="billing" class="btn btn-default visible-lg">
          <span class="fa fa-fw fa-chevron-left"></span>
          <span class="">Billing Details</span>
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