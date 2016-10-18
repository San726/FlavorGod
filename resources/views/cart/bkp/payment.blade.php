@extends('cart.layout')

@section('content')
  <form method="POST" role="form" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="page-title">
      @if($cart['status'] == 0)
      <a href="{{ url('cart/shipping') }}" class="btn btn-default btn-nav-back">
        <span class="fa fa-fw fa-chevron-left"></span>
      </a>
      @else
      <a href="{{ url('cart') }}" class="btn btn-default btn-nav-back">
        <span class="fa fa-fw fa-chevron-left"></span>
      </a>
      @endif
      <h1><span class="fa fa-fw fa-check-square-o card-icon"></span> Review &amp; Pay</h1>
      <div class="nav-dots">
        @if($cart['status'] == 0)
        <span class="fa fa-fw fa-circle"></span>
        @endif
        <span class="fa fa-fw fa-circle"></span>
        <span class="fa fa-fw fa-circle"></span>
        <span class="fa fa-fw fa-circle-o"></span>
      </div>
    </div>
    <div class="shopping-cart">
      <div class="row" style="margin-top: 12px">

        <div class=" col-xs-12 col-sm-6 pull-left">
          <!-- Contact Details -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><b class="fa fa-fw fa-user"></b> Contact Details</h4>
              <a href="{{ url('cart/contact?editing=1') }}" class="action"><span class="fa fa-fw fa-pencil-square-o"></span>Edit</a>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-12" style="padding: 0 30px">
                  <strong>{{ $cart['contact_firstname'].' '.$cart['contact_lastname'] }}</strong><br>
                  <span class="fa fa-fw fa-envelope-o" style="margin-right: 15px"></span>{{ $cart['contact_email'] }}<br>
                  @if(!empty($cart['contact_handle']))
                  <span class="fa fa-fw fa-instagram" style="margin-right: 15px"></span>{{ '@'.$cart['contact_handle'] }}<br>
                  @endif
                  @if(!empty($cart['contact_phone']))
                  <span class="fa fa-fw fa-phone" style="margin-right: 15px"></span>{{ $cart['contact_phone'] }}<br>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @if($cart['status'] == 0)
          <!-- Billing Details -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><b class="fa fa-fw fa-file-text-o"></b> Billing Details</h4>
              <a href="{{ url('cart/billing?editing=1') }}" class="action"><span class="fa fa-fw fa-pencil-square-o"></span>Edit</a>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-12" style="padding: 0 30px">
                  @foreach($billing as $line)
                  {{ $line }}<br>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>

        <div class="col-xs-12 col-sm-6 pull-left">
          <!-- Shipping Details -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><b class="fa fa-fw fa-truck fa-lg fa-flip-horizontal"></b> Shipping Details</h4>
              <a href="{{ url('cart/shipping?editing=1') }}" class="action"><span class="fa fa-fw fa-pencil-square-o"></span>Edit</a>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-12" style="padding: 0 30px">
                  @foreach($shipping as $line)
                  {{ $line }}<br>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if($cart['status'] == 0)
      @if(isset($errors))
      <div class="alert alert-danger" role="alert">
        <p><b class="fa fa-fw fa-lg fa-exclamation-circle"></b><strong>Error!</strong> The information provided is invalid. Please check to make sure you entered the right information.</p>
      </div>
      <div class="alert alert-warning" role="alert">
        <p><b class="fa fa-fw fa-lg fa-user-secret"></b><strong>Notice!</strong> For your security, we have disabled the autofill functionality for these fields. Please re-enter all values.</p>
      </div>
      @endif
      <div class="panel panel-default credit-card-box">
        <div class="panel-heading clearfix" style="padding: 0 5px">
          <img class="img-responsive pull-right" src="{{ asset('images/accepted_c22e0.png') }}">
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12 col-sm-9">
              <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('number') ? 'has-error' : 'has-warning' }} @endif">
                <label for="card_number" class="control-label">Card Number <span class="required-field">*</span></label>
                <div class="input-group">
                  <input type="tel" class="form-control" id="card_number" name="number" maxlength="19" value="" @if(isset($errors) && $errors->has('number')) autofocus @endif autocomplete="off" style="letter-spacing: 0.43em">
                  @if(isset($errors) && count($errors))
                  @if($errors->has('number'))
                  <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: 3em"></span>
                  @foreach($errors->get('number') as $error)
                  <span class="sr-only">{{ $error }}</span>
                  @endforeach
                  @else
                  <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="right: 3em"></span>
                  @endif
                  @endif
                  <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                </div>
              </div>
            </div>
            <div class="col-xs-5 col-sm-3">
              <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('cvv') ? 'has-error' : 'has-warning' }} @endif">
                <label for="card_cvv" title="Card Verification Value Code" class="control-label">CVV Code <span class="required-field">*</span></label>
                <input type="tel" class="form-control" id="card_cvv" name="cvv" maxlength="4" value="" autocomplete="off" style="letter-spacing: 0.43em">
                @if(isset($errors) && count($errors))
                @if($errors->has('cvv'))
                <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                @foreach($errors->get('cvv') as $error)
                <span class="sr-only">{{ $error }}</span>
                @endforeach
                @else
                <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                @endif
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-5 col-sm-3">
              <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('expiry_month') ? 'has-error' : 'has-warning' }} @endif">
                <label for="card_expiry_month" class="control-label"><span class="hidden-xs">Expiration</span><span class="visible-xs-inline">Exp</span> Month <span class="required-field">*</span></label>
                <input type="tel" class="form-control" id="card_expiry_month" name="expiry_month" placeholder="MM" maxlength="2" value="" autocomplete="off" style="letter-spacing: 0.43em">
                @if(isset($errors) && count($errors))
                @if($errors->has('expiry_month'))
                <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                @foreach($errors->get('expiry_month') as $error)
                <span class="sr-only">{{ $error }}</span>
                @endforeach
                @else
                <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                @endif
                @endif
              </div>
            </div>
            <div class="col-xs-7 col-sm-4">
              <div class="form-group @if(isset($errors) && count($errors)) has-feedback {{ $errors->has('expiry_year') ? 'has-error' : 'has-warning' }} @endif">
                <label for="card_expiry_year" class="control-label"><span class="hidden-xs">Expiration</span><span class="visible-xs-inline">Exp</span> Year <span class="required-field">*</span></label>
                <input type="tel" class="form-control" id="card_expiry_year" name="expiry_year" placeholder="YYYY" maxlength="4" value="" autocomplete="off" style="letter-spacing: 0.43em">
                @if(isset($errors) && count($errors))
                @if($errors->has('expiry_year'))
                <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                @foreach($errors->get('expiry_year') as $error)
                <span class="sr-only">{{ $error }}</span>
                @endforeach
                @else
                <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                @endif
                @endif
              </div>
            </div>
          </div>
          <div class="row" style="display:none;">
            <div class="col-xs-12">
              <p class="payment-errors"></p>
            </div>
          </div>
        </div>
      </div>
      @endif
      <!-- Totals -->
      <div class="totals clearfix">
        <div class="totals-item">
        <label>Subtotal</label>
        <div class="totals-value" id="cart-subtotal">{{ sprintf('%1.2f', $cart['sub_total']) }}</div>
        </div>
        @if($cart['tax'])
        <div class="totals-item">
        <!-- Tax only applied if shipping address in NJ -->
        <label>Tax ({{ $cart['tax_rate'] * 100 }}%)</label>
        <div class="totals-value" id="cart-tax">{{ sprintf('%01.2f', $cart['tax']) }}</div>
        </div>
        @endif
        <div class="totals-item">
        <label>Shipping</label>
        <div class="totals-value" id="cart-shipping">{{ sprintf('%01.2f', $cart['shipping_fee']) }}</div>
        </div>
        <div class="totals-item totals-item-total">
        <label>Grand Total</label>
        <div class="totals-value" id="cart-total">{{ sprintf('%01.2f', $cart['total']) }}</div>
        </div>
      </div>
      <!-- Action Buttons -->
      <div class="group action-buttons">
        @if($cart['status'] == 0)
        <div class="pull-right">
          <button type="submit" name="_next" value="process" class="btn btn-primary">
            <span class="fa fa-fw fa-lg fa-check"></span>
            <span>Confirm &amp; Submit</span>
          </button>
        </div>
        <div class="pull-left">
          <a href="{{ url('cart/shipping') }}" class="btn btn-default visible-lg">
            <span class="fa fa-fw fa-chevron-left"></span>
            <span class="">Shipping Details</span>
          </a>
        </div>
        @else
        <div class="pull-right">
          <button type="submit" name="_next" value="process" class="btn btn-default btn-checkout btn-paypal">
          <span class="paypal">
            <span class="pay"></span>
            <span class="pal"></span>
          </span>
            <span>
              Confirm &amp; Submit
            </span>
            <span class="fa fa-fw fa-check"></span>
          </button>
        </div>
        <div class="pull-left">
          <a href="{{ url('cart') }}" class="btn btn-default visible-lg">
            <span class="fa fa-fw fa-chevron-left"></span>
            <span class="">Edit Cart</span>
          </a>
        </div>
        @endif
      </div>
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