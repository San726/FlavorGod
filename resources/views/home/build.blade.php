@extends('app')

@section('bodyClass') product @stop
@section('content')
        <!-- Middle section coding starts here-->

        <!--Product section coding start here-->
        <div class="product-section build-your-own section">
            <div class="container">
                <div class="row white-bg">
                    <!--Product Slider coding start here-->
                    <div class="col-xs-12 col-sm-6 product-slider">
                        <div class="zoom-product">
                            <div class="sync1 owl-carousel">
                                <div class="item"><img src="/images/gallery-pro-red.png" alt="" title="" class="gallery-item"/></div>
                                <div class="item"><img src="/images/gallery-pro-green.png" alt="" title="" class="gallery-item"/></div>
                                <div class="item"><img src="/images/gallery-pro-yellow.png" alt="" title="" class="gallery-item"/></div>
                            </div>
                            <div class="zoom-lightbox"><img src="/images/zoom-btn.png" alt="Zoom Product" title="Zoom Product" /></div>
                        </div>
                        <div class="modal fade" id="zoom-product-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel2">View Everything Spicy Seasoning Label</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="review-thumb">
                                            <img src="/images/prod-green.png" alt="" title="" />
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="sync2 owl-carousel">
                            <div class="item"><div class="thumb-border"><img src="/images/thumb-gallery-img-red.jpg" alt="" title="" /></div></div>
                            <div class="item"><div class="thumb-border"><img src="/images/thumb-gallery-img-green.jpg" alt="" title="" /></div></div>
                            <div class="item"><div class="thumb-border"><img src="/images/thumb-gallery-img-yellow.jpg" alt="" title="" /></div></div>
                        </div>
                    </div>
                    <!--Product Slider coding ends here-->
                    <!--Product details coding start here-->
                    <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1 product-details">
                        <h2>Build Your Own Combo</h2>
                        <h3>Must Choose 4 Bottles</h3>
                        <div class="sale-price">Sale Price: <span>$34.99</span></div>
                        <p class="tag-line">You asked and we listened... <span>now you can build your own combo!</span></p>
                        <p>The FlavorGod Combo Pack is here to challenge the bland food army. Equipped with Fresh Herbs from Southern California, this pack of seasoning is guaranteed to take your taste buds where they have never been before. Say goodbye to the bland protein and boring veggies, this stuff right here will have you eating the way you deserve in no time.
                        </p>
                        <!--Choose bottles coding start here-->
                        <div class="choose-bottle">
                            <form>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Choose Your First Bottle</label>
                                            <div class="custom-option">
                                                <div class="custom-option-header">
                                                    Everything
                                                </div>
                                                <div class="custom-option-content">
                                                    <ul>
                                                        <li>
                                                            <div class="checkbox custom-radio chk-all">
                                                                <input id="chk11" type="checkbox">
                                                                <label for="chk11">Everything</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk12" type="checkbox">
                                                                <label for="chk12">Garlic Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk13" type="checkbox">
                                                                <label for="chk13">Lemon & Garlic</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk14" type="checkbox">
                                                                <label for="chk14">Everything Spicy</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk15" type="checkbox">
                                                                <label for="chk15">Onion Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk16" type="checkbox">
                                                                <label for="chk16">No Salt</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Choose Your Second Bottle</label>
                                            <!--<div class="custom-select">-->
                                            <!--<span><select class="form-control"><option>Garlic Lovers</option></select></span>-->
                                            <div class="custom-option">
                                                <div class="custom-option-header">
                                                    Garlic Lovers
                                                </div>
                                                <div class="custom-option-content">
                                                    <ul>
                                                        <li>
                                                            <div class="checkbox custom-radio chk-all">
                                                                <input id="chk21" type="checkbox">
                                                                <label for="chk21">Everything</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk22" type="checkbox">
                                                                <label for="chk22">Garlic Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk23" type="checkbox">
                                                                <label for="chk23">Lemon & Garlic</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk24" type="checkbox">
                                                                <label for="chk24">Everything Spicy</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk25" type="checkbox">
                                                                <label for="chk25">Onion Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk26" type="checkbox">
                                                                <label for="chk26">No Salt</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Choose Your Third Bottle</label>
                                            <div class="custom-option">
                                                <div class="custom-option-header">
                                                    Lemon &amp; Garic
                                                </div>
                                                <div class="custom-option-content">
                                                    <ul>
                                                        <li>
                                                            <div class="checkbox custom-radio chk-all">
                                                                <input id="chk31" type="checkbox">
                                                                <label for="chk31">Everything</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk32" type="checkbox">
                                                                <label for="chk32">Garlic Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk33" type="checkbox">
                                                                <label for="chk33">Lemon & Garlic</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk34" type="checkbox">
                                                                <label for="chk34">Everything Spicy</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk35" type="checkbox">
                                                                <label for="chk35">Onion Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk36" type="checkbox">
                                                                <label for="chk36">No Salt</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Choose Your Fourth Bottle</label>
                                            <div class="custom-option">
                                                <div class="custom-option-header">
                                                    Lemon &amp; Garic
                                                </div>
                                                <div class="custom-option-content">
                                                    <ul>
                                                        <li>
                                                            <div class="checkbox custom-radio chk-all">
                                                                <input id="chk41" type="checkbox">
                                                                <label for="chk41">Everything</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk42" type="checkbox">
                                                                <label for="chk42">Garlic Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk43" type="checkbox">
                                                                <label for="chk43">Lemon & Garlic</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk44" type="checkbox">
                                                                <label for="chk44">Everything Spicy</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk45" type="checkbox">
                                                                <label for="chk45">Onion Lovers</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk46" type="checkbox">
                                                                <label for="chk46">No Salt</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="button" class="btn btn-default btn-block" title="BUY THE COMBO SET W/EBOOKS" data-toggle="modal" data-target="#select-bottles">Buy The Combo Set w/Ebooks</button>
                                        <!--Select bottles coding start here-->
                                        <div class="modal fade" id="select-bottles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="select-bottle-bg">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel3">SELECT YOUR BOTTLE</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="select-bottle">
                                                                <ul>
                                                                    <li>
                                                                        <a href="#">
                                                                            <img src="images/select-bottle.jpg" alt="" title="" />
                                                                        </a>
                                                                        <div class="select-txt">SELECTED</div>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <img src="images/select-bottle.jpg" alt="" title="" />
                                                                        </a>
                                                                        <div class="select-txt">SELECTED</div>
                                                                    </li>
                                                                    <li class="select">
                                                                        <a href="#">
                                                                            <img src="images/select-bottle.jpg" alt="" title="" />
                                                                        </a>
                                                                        <div class="select-txt">SELECTED</div>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <img src="images/select-bottle.jpg" alt="" title="" />
                                                                        </a>
                                                                        <div class="select-txt">SELECTED</div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="red-fill"><a title="CONFIRM" href="#">CONFIRM</a></div>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="back" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">BACK</span></button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Select bottles coding ends here-->

                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--Choose bottles coding ends here-->
                        <!--shipping coding start here-->
                        <div class="shipping-charge">
                            <span class="free-shipping">US Shipping (FREE)</span>
                            Canada Shipping (+$9)
                            <div class="shipping-state">
                                Priority Shipping (+$8)<br>
                                International Shipping (+$17)
                            </div>
                        </div>
                        <!--shipping coding ends here-->
                        <!--Links start here-->
                        <ul class="seasoning-label">
                            <li><a href="#" title="View Everything Seasoning Label" data-toggle="modal" data-target="#seasoning-label1">View Everything Seasoning Label</a>
                                <!--Popup code start here-->
                                <div class="modal fade" id="seasoning-label1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel4">View Everything Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Popup code ends here-->
                            </li>
                            <li><a href="#" title="View Garlic Lovers Seasoning Label" data-toggle="modal" data-target="#seasoning-label2">View Garlic Lovers Seasoning Label</a>
                                <!--Popup code start here-->
                                <div class="modal fade" id="seasoning-label2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel5">View Garlic Lovers Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Popup code ends here-->

                            </li>
                            <li><a href="#" title="View Lemon & Garlic Seasoning Label" data-toggle="modal" data-target="#seasoning-label3">View Lemon &amp; Garlic Seasoning Label</a>
                                <!--Popup code start here-->
                                <div class="modal fade" id="seasoning-label3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel6">View Lemon &amp; Garlic Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Popup code ends here-->
                            </li>
                            <li><a href="#" title="View Everything Spicy Seasoning Label" data-toggle="modal" data-target="#seasoning-label4">View Everything Spicy Seasoning Label</a>
                                <!--Popup code start here-->
                                <div class="modal fade" id="seasoning-label4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel7">View Everything Spicy Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Popup code ends here-->
                            </li>
                        </ul>
                        <!--Links ends here-->
                    </div>
                    <!--Product details coding ends here-->
                </div>
                <!--CTA Banner coding start here-->
                <div class="row">
                    <div class="col-xs-12 adv-offer">
                        <a href="store"><h4>TAKE ME BACK TO THE ENTIRE STORE</h4></a>
                    </div>
                </div>
                <!--CTA Banner coding end here-->
            </div>
        </div>
        <!--Product section coding ends here-->
        <!-- Middle section coding ends here-->

@stop