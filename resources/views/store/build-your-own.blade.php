@inject('renderer', 'Flavorgod\Http\services\HtmlAssetRenderer')
@extends('app')
@section('bodyClass') product @stop
@section('content')

	        <!--Product section coding start here-->
       	<div class="product-section build-your-own section">
            <div class="container">
            	@foreach($product['variants'] as $variant)

	            	<div class="row white-bg">
	            		 <!--Product Slider coding start here-->
	                    <div class="col-xs-12 col-sm-6 product-slider">
	                        <div class="zoom-product">
	                            <div class="sync1 owl-carousel">
	                                <div class="item"><img src="{{ $variant['assets']['slider_image'][0]['path'] }}" alt="" title="" class="gallery-item"/></div>
	                                <div class="item"><img src="{{ $variant['assets']['slider_image'][1]['path'] }}" alt="" title="" class="gallery-item"/></div>
	                                <div class="item"><img src="{{ $variant['assets']['slider_image'][2]['path'] }}" alt="" title="" class="gallery-item"/></div>
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
	                                            <img src="images/prod-green.png" alt="" title="" />
	                                        </div>

	                                    </div>

	                                </div>
	                            </div>
	                        </div>
	                        <div class="sync2 owl-carousel">
	                        	{{ $renderer->thumbnail($variant, $variant['assets']['thumbnail_slider'][0]) }}
	                        	{{ $renderer->thumbnail($variant, $variant['assets']['thumbnail_slider'][1]) }}
	                        	{{ $renderer->thumbnail($variant, $variant['assets']['thumbnail_slider'][2]) }}
	                        </div>
	                    </div>	
	                    <!--Product Slider coding ends here-->
	                    <!--Product details coding start here-->
	                    <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1 product-details">
                        <h2>Build Your Own Combo</h2>
                        <h3>Must Choose 4 Bottles</h3>
                        <div class="sale-price">Sale Price: <span>${{ $variant['price'] }}</span></div>
                        <p class="tag-line">You asked and we listened... <span>now you can build your own combo!</span></p>
                        <p>{{ $renderer->withoutTags($variant['assets']['Description']['0']['path']) }}</p>
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
                                                        @for($i = 1; $i < count($variant['includes']) + 1; $i++)
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk1{{ $i }}" type="checkbox">
                                                                <label for="chk1{{ $i }}">{{ $variant['includes'][$i - 1]['name'] }}</label>
                                                            </div>
                                                        </li>
                                                        @endfor
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
                                                       @for($i = 1; $i < count($variant['includes']) + 1; $i++)
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk2{{ $i }}" type="checkbox">
                                                                <label for="chk2{{ $i }}">{{ $variant['includes'][$i - 1]['name'] }}</label>
                                                            </div>
                                                        </li>
                                                        @endfor 
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
                                                        @for($i = 1; $i < count($variant['includes']) + 1; $i++)
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk3{{ $i }}" type="checkbox">
                                                                <label for="chk3{{ $i }}">{{ $variant['includes'][$i - 1]['name'] }}</label>
                                                            </div>
                                                        </li>
                                                        @endfor 
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
                                                       @for($i = 1; $i < count($variant['includes']) + 1; $i++)
                                                        <li>
                                                            <div class="checkbox custom-radio">
                                                                <input id="chk4{{ $i }}" type="checkbox">
                                                                <label for="chk4{{ $i }}">{{ $variant['includes'][$i - 1]['name'] }}</label>
                                                            </div>
                                                        </li>
                                                        @endfor 
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
	        	@endforeach
	        	 <!--CTA Banner coding start here-->
                <div class="row">
                    <div class="col-xs-12 adv-offer">
                        <a href="#"><h4>TAKE ME BACK TO THE ENTIRE STORE</h4></a>
                    </div>
                </div>
                <!--CTA Banner coding end here-->
            </div>
        </div>
@stop