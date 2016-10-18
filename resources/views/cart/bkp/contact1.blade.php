@extends('cart.layout')

@section('content')
  <form class="form-horizontal" method="POST" role="form" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if($editing)
    <input type="hidden" name="editing" value="1">
    @endif
    <div class="page-title">
      @if(!$editing)
      <a href="{{ url('cart') }}" onclick="javascript:document.forms[0]._prev.click();return false;" class="btn btn-default btn-nav-back">
        <span class="fa fa-fw fa-chevron-left"></span>
      </a>
      @endif
      @if($loginType == 1)
      <h1><span class="fa fa-fw fa-user card-icon"></span> Customer Login</h1>
      @elseif($loginType == 2)
      <h1><span class="fa fa-fw fa-user card-icon"></span> New Customer</h1>
      @else
      <h1><span class="fa fa-fw fa-user card-icon"></span> Contact Details</h1>
      @endif
      <div class="nav-dots">
        <span class="fa fa-fw fa-circle-o"></span>
        <span class="fa fa-fw fa-circle"></span>
        <span class="fa fa-fw fa-circle"></span>
        @if($cart['status'] == 0)
        <span class="fa fa-fw fa-circle"></span>
        @endif
      </div>
    </div>
    @if(isset($errors))
    <div class="alert alert-danger" role="alert">
      <strong>Error!</strong> The information provided is invalid. Please check to make sure you entered the right information.
    </div>
    @endif
    @if($signedIn)
    <div class="group">
      {{-- VISIBLE ON: SIGNED IN --}}
      <div class="row">
        <div class="col-sm-10 col-md-8 col-sm-offset-1 col-sm-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><b>Checkout As</b></h4>
            </div>
            <div class="panel-body">
              <h3>John Doe</h3>
              <h5>johndoe@flavorgod.com</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    @elseif($loginType == 1)
    <div class="group">
      {{-- VISIBLE ON: LOGIN, SIGN-UP, & GUEST CHECKOUT --}}
      <!-- Contact Email -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('contact_email') ? 'has-error' : 'has-success' }} @endif">
        <label for="contact_email" class="col-sm-3 control-label">Email<span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="email" class="form-control" name="contact_email" id="contact_email" value="{{ isset($input['contact_email']) ? $input['contact_email'] : $cart['contact_email'] }}" onfocus="this.select();" onmouseup="return false;">
          @if(isset($errors) && count($errors))
          @if($errors->has('contact_email'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('contact_email') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      {{-- VISIBLE ON: LOGIN & SIGN-UP --}}
      <!-- Contact Password -->
      <div class="form-group">
        <label for="password" class="col-sm-3 control-label">Password <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="password" class="form-control" name="password" id="password">
        </div>
      </div>

      <hr>

    </div>
    @elseif($loginType == 2)
    <div class="group">
      {{-- VISIBLE ON: SIGN-UP & GUEST CHECKOUT --}}
      <!-- Contact Name -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('contact_name') ? 'has-error' : 'has-success' }} @endif">
        <label for="contact_name" class="col-sm-3 control-label">First &amp; Last Name<span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="contact_name" id="contact_name" value="{{ isset($input['contact_name']) ? $input['contact_name'] : $cart['contact_name'] }}" onfocus="this.select();" onmouseup="return false;" @if(isset($errors) && $errors->has('contact_name')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('contact_name'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('contact_name') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      {{-- VISIBLE ON: LOGIN, SIGN-UP, & GUEST CHECKOUT --}}
      <!-- Contact Email -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('contact_email') ? 'has-error' : 'has-success' }} @endif">
        <label for="contact_email" class="col-sm-3 control-label">Email<span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="email" class="form-control" name="contact_email" id="contact_email" value="{{ isset($input['contact_email']) ? $input['contact_email'] : $cart['contact_email'] }}" onfocus="this.select();" onmouseup="return false;">
          @if(isset($errors) && count($errors))
          @if($errors->has('contact_email'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('contact_email') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      {{-- VISIBLE ON: LOGIN & SIGN-UP --}}
      <!-- Contact Password -->
      <div class="form-group">
        <label for="password" class="col-sm-3 control-label">Password <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="password" class="form-control" name="password" id="password">
        </div>
      </div>

      {{-- VISIBLE ON: SIGN-UP --}}
      <!-- Contact Password 2-->
      <div class="form-group">
        <label for="password2" class="col-sm-3 control-label">Retype Password <span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="password" class="form-control" name="password2" id="password2">
        </div>
      </div>

    </div>
    @elseif($loginType == 3)
    <div class="group">
      {{-- VISIBLE ON: GUEST CHECKOUT --}}
      <!-- Contact Name -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('contact_name') ? 'has-error' : 'has-success' }} @endif">
        <label for="contact_name" class="col-sm-3 control-label">First &amp; Last Name<span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="text" class="form-control" name="contact_name" id="contact_name" value="{{ isset($input['contact_name']) ? $input['contact_name'] : $cart['contact_name'] }}" onfocus="this.select();" onmouseup="return false;" @if(isset($errors) && $errors->has('contact_name')) autofocus @endif>
          @if(isset($errors) && count($errors))
          @if($errors->has('contact_name'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('contact_name') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      {{-- VISIBLE ON: LOGIN, SIGN-UP, & GUEST CHECKOUT --}}
      <!-- Contact Email -->
      <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('contact_email') ? 'has-error' : 'has-success' }} @endif">
        <label for="contact_email" class="col-sm-3 control-label">Email<span class="required-field">*</span></label>
        <div class="col-sm-9 col-md-6">
          <input type="email" class="form-control" name="contact_email" id="contact_email" value="{{ isset($input['contact_email']) ? $input['contact_email'] : $cart['contact_email'] }}" onfocus="this.select();" onmouseup="return false;">
          @if(isset($errors) && count($errors))
          @if($errors->has('contact_email'))
          <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
          @foreach($errors->get('contact_email') as $error)
          <span class="sr-only">{{ $error }}</span>
          @endforeach
          @else
          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
          @endif
          @endif
        </div>
      </div>

      <!-- Contact Phone -->

    </div>
    @endif

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
        <button type="submit" name="_next" value="paypal" class="btn btn-default btn-checkout btn-paypal">
          <span style="font-size:0.9em">
            Pay with
          </span>
          <span class="paypal">
            <span class="pay"></span>
            <span class="pal"></span>
          </span>
        </button>
        <button type="submit" name="_next" value="billing" class="btn btn-primary">
          <span class="fa fa-credit-card fa-fw fa-lg"></span>
          <span>
            Pay with Card
          </span>
          <span class="fa fa-fw fa-chevron-right"></span>
        </button>
      </div>
      <div class="pull-left">
        <button type="submit" name="_prev" value="cart" class="btn btn-default visible-lg">
          <span class="fa fa-fw fa-chevron-left"></span>
          <span class="">Edit Cart</span>
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