@extends('app')

@section('bodyClass') product @stop
@section('content')



        <!-- Middle section coding starts here-->
        <!--Product section coding starts here-->
        <div class="product-section section">
            <div class="container">

                <div class="row white-bg">
                    <div class="col-xs-12 col-sm-6 product-slider">
                        <div class="zoom-product">
                            <div class="sync1 owl-carousel">
                                <div class="item"><img src="/images/gallery-pro-red.png" alt="" title="" class="gallery-item"/></div>
                                <div class="item"><img src="/images/gallery-pro-green.png" alt="" title="" class="gallery-item"/></div>
                                <div class="item"><img src="/images/thumb-gallery-img-video.png" alt="" title="" class="gallery-item"/></div>
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
                            <div class="item item-video"><div class="thumb-border"><a href="http://www.youtube.com/watch?v=7HKoqNJtMTQ"><img src="images/thumb-gallery-img-video.png" alt="" title="" /></a></div></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1 product-details">
                        <h2>Classic Combo Set</h2>
                        <h3>w/Two Recipe Books</h3>
                        <div class="sale-price">Sale Price: <span>$34.99</span></div>
                        <p class="tag-line">Ladies and gentleman, boys and girls, this is what we call <span>the super heroes of seasoning.</span></p>
                        <p>The FlavorGod Combo Pack is here to challenge the bland food army. Equipped with Fresh Herbs from Southern California, this pack of seasoning is guaranteed to take your taste buds where they have never been before. Say goodbye to the bland protein and boring veggies, this stuff right here will have you eating the way you deserve in no time.
                        </p>
                        <div class="red-fill"><a href="viewcart.html" title="BUY THE COMBO SET W/EBOOKS">Buy The Combo Set w/Ebooks</a></div>

                        <div class="shipping-charge">
                            <span class="free-shipping">US Shipping (FREE)</span>
                            Canada Shipping (+$9)
                            <div class="shipping-state">
                                Priority Shipping (+$8)<br>
                                International Shipping (+$17)
                            </div>
                        </div>

                        <ul class="seasoning-label">
                            <li><a href="#" title="View Everything Seasoning Label" data-toggle="modal" data-target="#seasoning-label1">View Everything Seasoning Label</a>
                                <div class="modal fade" id="seasoning-label1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel3">View Everything Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="#" title="View Garlic Lovers Seasoning Label" data-toggle="modal" data-target="#seasoning-label2">View Garlic Lovers Seasoning Label</a>
                                <div class="modal fade" id="seasoning-label2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel4">View Garlic Lovers Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="#" title="View Lemon & Garlic Seasoning Label" data-toggle="modal" data-target="#seasoning-label3">View Lemon &amp; Garlic Seasoning Label</a>
                                <div class="modal fade" id="seasoning-label3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel5">View Lemon &amp; Garlic Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="#" title="View Everything Spicy Seasoning Label" data-toggle="modal" data-target="#seasoning-label4">View Everything Spicy Seasoning Label</a>
                                <div class="modal fade" id="seasoning-label4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel6">View Everything Spicy Seasoning Label</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="images/prod-green.png" alt="" title="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="row white-bg what-included">
                    <div class="col-xs-12 text-center">
                        <h2>What Is <strong>Included</strong></h2>
                        <div class="row included-items">
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="images/included-img-1.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="View Label">View Label</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="images/included-img-2.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="View nutrition facts">View nutrition facts</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="images/included-img-3.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="Preview Book">Preview Book</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="images/included-img-3.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="Preview Book">Preview Book</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="images/included-img-1.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="View Label">View Label</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="images/included-img-2.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="View nutrition facts">View nutrition facts</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="/images/included-img-3.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="Preview Book">Preview Book</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <div class="include-img">
                                    <img src="/images/included-img-3.png" alt="" />
                                </div>
                                <a href="#" class="include-btn" title="Preview Book">Preview Book</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row white-bg">
                    <div class="col-xs-12 col-sm-6 product-slider">
                        <div class="zoom-product">
                            <div class="sync1 owl-carousel">
                                <div class="item"><img src="images/gallery-pro-red.png" alt="" title="" class="gallery-item"/></div>
                                <div class="item"><img src="images/gallery-pro-green.png" alt="" title="" class="gallery-item"/></div>
                                <div class="item"><img src="images/gallery-pro-yellow.png" alt="" title="" class="gallery-item"/></div>
                            </div>
                            <div class="zoom-lightbox"><img src="images/zoom-btn.png" alt="Zoom Product" title="Zoom Product" /></div>
                        </div>
                        <div class="modal fade" id="zoom-product-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
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
                        <div id="sync2" class="sync2 owl-carousel">
                            <div class="item"><div class="thumb-border"><img src="images/thumb-gallery-img-red.jpg" alt="" title="" /></div></div>
                            <div class="item"><div class="thumb-border"><img src="images/thumb-gallery-img-green.jpg" alt="" title="" /></div></div>
                            <div class="item"><div class="thumb-border"><img src="images/thumb-gallery-img-yellow.jpg" alt="" title="" /></div></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1 product-details">
                        <h2>Chef Apron</h2>
                        <h3>Limited Edition</h3>
                        <div class="sale-price">Sale Price: <span>$19.99</span></div>
                        <p class="tag-line">Get one while supplies last and show the world <span>that you’re a FLAVORGOD Chef!</span></p>
                        <p class="red-txt">ONE SIZE FITS ALL</p>
                        <p>Designed by Christopher Wallace thease Aprons are hand sewn and printed in the USA. This is a high-end apron that will enhance your status in the kitchen and shows your support for your favorite seasonings!
                        </p>
                        <div class="red-fill"><a href="viewcart.html" title="BUY THE FLAVORGOD APRON">BUY THE FLAVORGOD APRON</a></div>



                        <div class="shipping-charge">
                            <span class="free-shipping">US Shipping (FREE)</span>
                            Canada Shipping (+$9)
                            <div class="shipping-state">
                                Priority Shipping (+$8)<br>
                                International Shipping (+$17)
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 adv-offer">
                        <a href="#">
                            <h4>TAKE ME BACK TO THE ENTIRE STORE</h4>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!--Product section coding ends here-->
        <!-- Middle section coding ends here-->
   @stop