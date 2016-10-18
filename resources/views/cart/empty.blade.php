@extends('cart.layout')

@section('bodyClass') cart-details @stop
@section('content')
@section('spinner', '')

        <!--cart section coding starts here-->
        <div class="cart-section section">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 pdlf0">
                        <h2>CART</h2>
                    </div>
                </div>
                <!--cart form coding starts here-->
                <form>
                    <div class="row white-bg">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table class="cart-table table table-condensed">
                                    <tr class="heading">
                                        <th colspan="3">Product</th>
                                        <th>PRICE</th>
                                        <th>Quantity</th>
                                        <th>total</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row proceed-checkout">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 checkout-pd checkout-txt">Apply Coupon Code <span>Here</span></div>
                                <div class="col-xs-12 col-sm-6 checkout-pd1">
                                    <div class="form-group">
                                        <input type="text" placeholder="COUPONCODE" id="txtcoupon" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 checkout-pd checkout-txt">Estimate<span> SHIPPING &amp; HANDLING</span></div>
                                <div class="col-xs-12 col-sm-6 checkout-pd1">
                                    <div class="form-group custom-select">
                                        <span>
                                            <select class="form-control">
                                                <option>CHOOSE COUNTRY</option>
                                                <option>India</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-6 chkout-btn checkout-pd1">
                                    <button title="Proceed To Checkout" class="btn btn-default btn-block" type="submit">Proceed To Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--cart form coding ends here-->
                <!--Featured add-on Products coding starts here-->
                <div class="sec-product">
                    <h4>Featured add-on Products</h4>
                    <ul class="row">
                        <li class="col-sm-6 col-md-4  col-lg-3">
                            <div class="prod-single prod-red">
                                <a href="product.html" class="prod-img" title="7 Bottle Combo Pack">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/prod-red.png" alt=""  title=""/>
                                            <div class="prod-overlay">
                                                <div class="dis-table">
                                                    <div class="dis-table-cell">
                                                        <p>
                                                            <img src="/images/prod-hover.png" alt="" />
                                                            <span>click to Learn More</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="prod-cat">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/icon-chilli.png" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="prod-descr">
                                    <h2><a href="product.html" title="7 Bottle Combo Pack">7 Bottle Combo Pack</a></h2>
                                    <h3>
                                        <small>$ 19.99</small>
                                        <span>$ 8.99</span>
                                    </h3>
                                </div>
                            </div>
                        </li>
                        <li class="col-sm-6 col-md-4 col-lg-3">
                            <div class="prod-single prod-green">
                                <a href="product.html" class="prod-img" title="Classic Combo Pack">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/prod-green.png" alt="" />
                                            <div class="prod-overlay">
                                                <div class="dis-table">
                                                    <div class="dis-table-cell">
                                                        <p>
                                                            <img src="/images/prod-hover.png" alt="" />
                                                            <span>click to Learn More</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="prod-cat">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/icon-chilli.png" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="prod-descr">
                                    <h2><a href="product.html" title="Classic Combo Pack">Classic Combo Pack</a></h2>
                                    <h3>
                                        <small>$ 19.99</small>
                                        <span>$ 8.99</span>
                                    </h3>
                                </div>
                            </div>
                        </li>
                        <li class="col-sm-6 col-md-4 col-lg-3">
                            <div class="prod-single prod-yellow">
                                <a href="product.html" class="prod-img" title="Specialty Combo Pack">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/prod-yellow.png" alt="" title="" />
                                            <div class="prod-overlay">
                                                <div class="dis-table">
                                                    <div class="dis-table-cell">
                                                        <p>
                                                            <img src="/images/prod-hover.png" alt="" />
                                                            <span>click to Learn More</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="prod-cat">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/icon-chilli.png" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="prod-descr">
                                    <h2><a href="product.html" title="Specialty Combo Pack">Specialty Combo Pack</a></h2>
                                    <h3>
                                        <small>$ 19.99</small>
                                        <span>$ 8.99</span>
                                    </h3>
                                </div>
                            </div>
                        </li>
                        <li class="col-sm-6 col-md-4 col-lg-3">
                            <div class="prod-single prod-black">
                                <a href="product.html" class="prod-img" title="Jerky Combo Pack">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/prod-black.png" alt="" title="" />
                                            <div class="prod-overlay">
                                                <div class="dis-table">
                                                    <div class="dis-table-cell">
                                                        <p>
                                                            <img src="/images/prod-hover.png" alt="" />
                                                            <span>click to Learn More</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="prod-cat">
                                    <div class="dis-table">
                                        <div class="dis-table-cell">
                                            <img src="/images/icon-chilli.png" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="prod-descr">
                                    <h2><a href="product.html" title="Jerky Combo Pack">Jerky Combo Pack</a></h2>
                                    <h3>
                                        <small>$ 19.99</small>
                                        <span>$ 8.99</span>
                                    </h3>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--Featured add-on Products coding ends here-->
            </div>
        </div>
        <!--cart section coding ends here-->

@stop