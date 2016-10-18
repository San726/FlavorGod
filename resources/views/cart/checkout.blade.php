@extends('cart.layout')

@section('bodyClass') cart-details @stop
@section('content')

        <!--Cart section coding start here-->
        <div class="cart-section checkout-details section">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 pdlf0">
                        <h2>CHECKOUT</h2>
                    </div>
                </div>
                    <div class="row checkout-table">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table class="cart-table table table-condensed">
                                    <tr>
                                        <td class="white-bg">
                                            <table class="table table-condensed table-content">
                                                <tr class="heading">
                                                    <th>Product</th>
                                                    <th class="hidden-xs">Price</th>
                                                    <th class="hidden-xs">Quantity</th>
                                                    <th class="hidden-xs">Total</th>
                                                </tr>
                                                @foreach($cart['items'] as $item)
                                                <tr>
                                                    <td class="product-img visible-xs">
                                                        <img src="//placehold.it/150x150" alt="" />
                                                    </td>
                                                    <td class="product-info">
                                                        <h4>{{ $item['name'] }}</h4>
                                                        <p>{{ $item['sku'] }}</p>
                                                    </td>
                                                    <td  class="price-txt">
                                                        <span class="visible-xs">Price:</span>
                                                        ${{ number_format($item['price'], 2) }}
                                                    </td>
                                                    <td  class="quanity">
                                                        <span class="visible-xs">Qty:</span>
                                                        {{ $item['quantity'] }}
                                                    </td>
                                                    <td  class="total-txt">
                                                        <span class="visible-xs">Total:</span>
                                                        ${{ number_format($item['total'], 2) }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sub-total-table">
                                            <table class="table table-condensed">
                                                <tr>
                                                    <td>Cart Subtotal</td>
                                                    <td>${{ number_format($cart['sub_total'], 2) }}</td>

                                                </tr>
                                                <tr>
                                                    <td>Shipping & Handling</td>
                                                    @if(empty($cart['shipping_fee']))
                                                    <td>FREE</td>
                                                    @else
                                                    <td>${{ number_format($cart['shipping_fee'], 2) }}</td>
                                                    @endif

                                                </tr>
                                                @if(!empty($cart['tax_rate']))
                                                <tr>
                                                    <td>Tax ({{ round($cart['tax_rate'] * 100) }}%)</td>
                                                    <td>${{ number_format($cart['tax'], 2) }}</td>
                                                </tr>
                                                @endif
                                                <tr class="order-total">
                                                    <td>Order Total</td>
                                                    <td>${{ number_format($cart['total'], 2) }}</td>

                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--Address code start here-->
                    <form method="POST">
                    <div class="address-info">
                        <div class="row">
                        @if (count($errors) > 0)
                        <div class="col-xs-12">
                           <div class="alert alert-danger" role="alert">
                                 <ul>
                                    @foreach ($errors as $field => $error)
                                        <li><strong>{{ $field }}:</strong> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="col-xs-12">


                            <h4>Credit <span>Card</span></h4>

                            <div class="row">
                                {!! csrf_field() !!}
                                <div class="col-xs-10">
                                    <div class="form-group">
                                        <input type="text" placeholder="Number" name="number" id="txtfname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group">
                                        <input type="text" placeholder="CVV" name="cvv" id="txtfname" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Expire Month" name="expiry_month" id="txtlname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Expire Year" name="expiry_year" id="txtlname" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!--Billing address start here-->
                            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 billing-adress">
                                <h4>Billing <span>Address</span></h4>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="First Name" name="billing_firstname" id="txtfname" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Last Name" name="billing_lastname" id="txtlname" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Address Line 1" name="billing_address" id="txtaddress1" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Address Line 2" name="billing_address2" id="txtaddress2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Town/City" name="billing_city" id="txttown" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="State" name="billing_state" id="txtstate" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Postcode/Zip" name="billing_zip" id="txtpostcode" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Phone Number" name="contact_phone" id="txtphone" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Billing address ends here-->
                                <!--shipping address start here-->
                                <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 shipping-adress">
                                    <h4>shipping <span>Address</span></h4>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="First Name" name="shipping_firstname" id="s-txtfname" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Last Name" name="shipping_lastname" id="s-txtlname" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Address Line 1" name="shipping_address" id="s-txtaddress1" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Address Line 2" name="shipping_address2" id="s-txtaddress2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Town/City" name="shipping_city" id="s-txttown" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="State" name="shipping_state" id="s-txtstate" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Postcode/Zip" name="shipping_zip" id="s-txtpostcode" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Phone Number" id="s-txtphone" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--shipping address ends here-->
                            </div>
                            <div class="row place-order">
                                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0">
                                    <button title="PLACE ORDER" class="btn btn-default btn-block" type="submit">Place Order</button>
                                </div>
                            </div>

                    </div>
                    </form>
                    <!--Address code ends here-->

            </div>
        </div>
        <!--Cart section coding ends here-->
@stop