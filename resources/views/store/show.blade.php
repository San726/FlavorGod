@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')
@section('bodyClass') product slimmer @stop
@section('content')
        <!-- Middle section coding starts here-->
        <!--Product section coding starts here-->
        <div class="product-section section">
            <div class="container">
            <?php
            $variantCount = 0;
            ?>
           @foreach($product['variants'] as $index => $variant)
           <?php
            $variantCount++;
           ?>
            <form action="/cart" id="cart-post-index" class="item-product {{ $index ? 'inactive' : 'active auto-active' }} {{ $variant['sku'] }}" data-original-position="{{ $index }}" data-product-sku="{{ $variant['sku'] }}" data-product-price="{{ $variant['price'] }}" data-flag="{{ @(in_array('sold-out', $variant['product_sets']['flags'])) ? 'true': 'false' }}" novalidate>
                <input type="hidden" name="_add" value="{{ $variant['sku'] }}">
                <!--Product title - Visible only on mobile-->
                <div class="product-title row white-bg">
                    <div class="col-xs-12">
                        <h2 class="title">{{ $variant['name'] }}</h2>
                        @if($variant['sub_name'])
                            <h3>{{ $variant['sub_name'] }}</h3>
                        @endif
                    </div>
                </div>
                <!--build choose your own-->
                @if($variant['product_type_id'] == 10)
                <div class="row white-bg">
                     <!--Product Slider coding start here-->
                    <div class="col-xs-12 col-sm-6 product-slider">
                        <div class="zoom-product">
                            <div class="sync1 owl-carousel">

                                @if(array_key_exists('slider_image', $variant['assets']))
                                    @foreach($variant['assets']['slider_image'] as $index => $slider)
                                    <div class="item  col-xs-4 col-sm-12"><img src="{{ $renderer->assetExists($variant['assets'], 'slider_image', 'image', $index) }}" alt="{{ @$asset['name'] }}" title="{{ @$asset['name'] }}" class="gallery-item"/></div>
                                   @endforeach
                               @endif
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
                        {{--
                        <div class="sync2 owl-carousel">
                            {{ $renderer->thumbnailSlider($variant, 'thumbnail_slider', 'image', 0) }}
                            {{ $renderer->thumbnailSlider($variant, 'thumbnail_slider', 'image', 1) }}
                            {{ $renderer->thumbnailSlider($variant, 'thumbnail_slider', 'image', 2) }}
                        </div>
                        --}}
                    </div>
                    <!--Product Slider coding ends here-->
                    <!--Product details coding start here-->
                    <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1 product-details">
                        <div class="product-title">
                            <h2 id="variant-title">{{ $variant['name'] }}</h2>
                            <h3 id="variant-subtitle"></h3>
                        </div>

                        <div class="msrp">
                            {{ $variant['msrp'] > $variant['price']? '$'.number_format($variant['msrp'], 2): '' }}
                        </div>

                        <div class="sale-price">Sale Price: <span>${{ number_format($variant['price'], 2) }}</span></div>
                        <div class="description">
                            {{ $renderer->htmlText('', $variant, 'description', 'text') }}
                        </div>
                        <!--Choose bottles coding start here-->
                        <div class="choose-bottle">
                            @for($i = 0; $i < $variant['product_combo_count']; $i++)
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Choose Your {{ ucfirst($renderer->numberToWords($i)) }} Bottle</label>
                                        <select class="form-control" name="_option[{{ $i }}]">
                                            @foreach($variant['includes'] as $include)
                                            <option value="{{ $include['sku'] }}">{{ $include['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="btn btn-default btn-block">Buy this product</div>
                            </div>
                        </div>
                    </div>
                    <!--Choose bottles coding ends here-->
                    <!--shipping coding start here-->
                    <div class="shipping-charge">
                        <span class="free-shipping">US Shipping (FREE) On Orders Over $50</span>
                        Canada Shipping (+$9)
                        <div class="shipping-state">
                            Priority Shipping (+$8)<br>
                            International Shipping (+$17)
                        </div>
                    </div>
                    <!--shipping coding ends here-->
                </div>
                <!--Product details coding ends here-->
                @else
                <div class="row white-bg main-actions iphone-overflow-fix">
                    <div class="col-xs-12 col-sm-6 align-center product-slider">
                        <div class="zoom-product sold-out-image-holder">
                              @if(count($variant['includes']) > 1)
                                    <div class="sync1 owl-carousel">
                                        <div class="item  col-xs-4 col-sm-12">
                                            <img src="{{ $renderer->assetExists($variant['assets'], 'primary_image', 'image', 0) }}" alt="{{ @$variant['name'] }}" title="{{ @$variant['name'] }}" class="gallery-item"/>
                                        </div>
                                        @foreach($variant['includes'] as $include)
                                            <?php
                                                if($include['name'] === 'Specialty Seasoning Information Card'){
                                                    continue;
                                                }else if($include['name'] === 'Salt & Pepper Information Card'){
                                                    continue;
                                                }
                                            ?>

                                            @if($variant['name'] != $include['name'])
                                            <div class="item  col-xs-4 col-sm-12">
                                                <img src="{{ $renderer->assetExists($include['assets'], 'primary_image', 'image', 0) }}" alt="{{ @$include['name'] }}" title="{{ @$include['name'] }}" class="gallery-item"/>
                                            </div>
                                            @endif
                                        @endforeach
                                     </div>
                                @else
                                    <div><img src="{{ $renderer->assetExists($variant['assets'], 'primary_image', 'image', 0) }}"></img></div>
                                @endif
                            <div class="zoom-lightbox"><img src="/images/zoom-btn.png" alt="Zoom product" title="Zoom product"/></div>
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
                                            <img src="" alt="" title="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--
                        <div class="sync2 owl-carousel">
                        {{ $renderer->thumbnailSlider($variant, 'thumbnail_slider', 'image', 0) }}
                        {{ $renderer->thumbnailSlider($variant, 'thumbnail_slider', 'image', 1) }}
                        {{ $renderer->thumbnailSlider($variant, 'thumbnail_slider', 'image', 2) }}
                        </div>
                        --}}
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-6 product-details">
                        <!--Product name - Desktop version. Hidden on mobile -->
                        <div class="product-title">
                            <h2 id="variant-title">{{ $variant['name'] }}</h2>
                            @if(isset($variant['sub_name']))
                                <h3>{{ $variant['sub_name'] }}</h3>
                            @endif

                            @if(!isset($variant['assets']['product_offer']))
                                <h3 id="variant-subtitle"></h3>
                            @endif
                            {{ $renderer->htmlText('<div>', $variant, 'product_offer', 'text') }}
                        </div>

                        <div class="sale-price clearfix">
                                <div class="price-text">
                                    Sale Price:
                                </div>
                                <div class="price-number">
                                    <span class="price-value">${{ number_format($variant['price'], 2) }}</span>
                                    <span class="msrp">{{ $variant['msrp'] > $variant['price']? '$'.number_format($variant['msrp'], 2): '' }}</span>
                                </div>
                        </div>

                        @if($variant['shippable'])
                        <div class="shipping-charge">
                            <span class="free-shipping">US Shipping (FREE) On Orders Over $50</span>
                            Canada Shipping (+$9)
                            <div class="shipping-state">
                                International Shipping ($17)
                            </div>
                        </div>
                        @endif

                        {{ $renderer->htmlText('<p><span>', $variant, 'pitch', 'text') }}
                        <div class="description">
                            <p class="text short">
                                {{ $renderer->htmlText('', $variant, 'description', 'text') }}
                            </p>
                            <p class="read-more" >Read more</p>
                        </div>

                        <div class="box-buttons">
                            <div class="no-left col-xs-6 box-add-cart">
                                @if(array_key_exists('flags', $variant['product_sets']))
                                    @if(in_array('sold-out', $variant['product_sets']['flags']))
                                            {{-- display form for first variant with sold out--}}
                                                <div class="showOnlyForFeaturedProduct" style="border: 1px solid #e9e9e9; padding: 10px 30px 30px 30px;">
                                                    <!-- <a style="background:#f3f3f3; border: 1px solid #d1d1d1; color: #d1d1d1;" class="btn btn-default btn-block">OUT OF STOCK</a> -->
                                                      <fieldset class="form-group">
                                                        <label for="exampleInputEmail1" style="color: #8c8c8c;"> Notify me when it's available</label>
                                                        <br />
                                                        <small class="text-muted">Enter your email address and we will let you know as soon as we have this item in stock.</small>
                                                      </fieldset>
                                                      <div class="alert alert-success" id="notify-success" role="alert" style="display:none;">...</div>
                                                        <div class="alert alert-danger" id="notify-error" role="alert" style="display:none;">...</div>
                                                      <div class="input-group">
                                                          <input id="out-of-stock-email" type="email" style="font-size: 16px; padding: 13px;" placeholder="Enter your email">
                                                          <span class="input-group-btn">
                                                            <button type="submit" style="font-size: 16px; margin: 0 0 0 -2px;" class="btn btn-default btn-block notify-button">NOTIFY</button>
                                                          </span>
                                                    </div>
                                                </div>
                                                {{-- display disabled button for second and third variant--}}
                                                <a style="background:#f3f3f3; border: 1px solid #d1d1d1; color: #d1d1d1;" class="btn btn-default btn-block">OUT OF STOCK</a>
                                    @else
                                    {{-- display add to cart button when no 'sold out' flags--}}
                                        <button type="" class="btn btn-default btn-block button-call-ajax">Add to cart</button>
                                    @endif
                                @else
                                    {{-- display add to cart button when no flags--}}
                                    <button type="" class="btn btn-default btn-block button-call-ajax">Add to cart</button>
                                @endif
                            </div>
                            <div class="no-right col-xs-6 box-view-details">
                                <div class="btn btn-secondary btn-view btn-block">View Details</div>
                            </div>
                        </div>

                        <div class="what-included">
                                @if(!empty($coupon_applied))
                                <div class="coupon-show">
                                    <i class="fa fa-check" aria-hidden="true"></i>Coupon
                                    <code><span class="coupon-value">{{ $coupon_applied }}</span></code> applied.
                                    <br>Add product to cart for discounted price.
                                </div>
                                @endif
                            <h3>What's included:</h3>
                            <ul class="seasoning-label">
                                @if($variant['includes'])
                                @foreach($variant['includes'] as $index => $include)
                                    <?php
                                        if($include['name'] === 'Specialty Seasoning Information Card'){
                                            continue;
                                        }else if($include['name'] === 'Salt & Pepper Information Card'){
                                            continue;
                                        }
                                    ?>
                                    <li><a href="#" title="{{ $include['name'] }}" data-toggle="modal" data-target="#seasoning-label{{ $index }}">{{ $include['name'] }}</a>
                                      <div class="modal fade" id="seasoning-label{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $index }}" style="display: none;" aria-hidden="true">
                                          <div class="modal-dialog" role="document" style="margin-top: 296.5px;">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close modal-close-button-position" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title" id="myModalLabel{{ $index }}">{{ $include['name'] }}</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="{{ $renderer->assetExists($include['assets'], 'product_label', 'image', 0) }}" alt="{{ @$asset['name'] }}" title="{{ @$asset['name'] }}">
                                                </div>

                                              </div>

                                            </div>
                                          </div>
                                    </div>
                                </li>
                                @endforeach
                                @else
                                    <li><a href="#" title="{{ $variant['name'] }}" data-toggle="modal" data-target="#{{ $variant['sku'] }}">{{ $variant['name'] }}</a>
                                      <div class="modal fade" id="{{ $variant['sku'] }}" tabindex="-1" role="dialog" aria-labelledby="{{ $variant['sku'] }}" style="display: none;" aria-hidden="true">
                                          <div class="modal-dialog" role="document" style="margin-top: 296.5px;">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title" id="{{ $variant['sku'] }}">{{ $variant['name'] }}</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="review-thumb">
                                                    <img src="{{ $renderer->assetExists($variant['assets'], 'product_label', 'image', 0) }}" alt="" title="">
                                                </div>

                                              </div>

                                            </div>
                                          </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>

                        <div id="addToCartModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                              <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header black-horizontal-line">
                                        <div class="row">
                                            <p class="modal-title text-center add-to-card-success"><i class="fa fa-check"></i>&nbsp;&nbsp;Added to cart!<p>
                                        </div>
                                        <div class="row added-product-image-flex-style">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 image-holder">
                                                <!-- <img class="img-responsive added-product-size" src="{{ $renderer->assetExists($variant['assets'], 'primary_image', 'image', 0) }}"> -->
                                                <img class="img-responsive added-product-size" src="">
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                <!-- <h3 class="modal-title added-product-heading">{{ $variant['name'] }}</h3> -->
                                                <h3 class="modal-title added-product-heading"></h3>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <p class="text-center"><a href="/cart" class="add-to-cart-modal-link"> Continue to checkout </a></p>
                                        </div>
                                    </div>
                                    <p class="frequently-bought-item-heading">Frequently Bought Together (Discounted)</p>
                                    <div class="modal-body frequently-bought-product-section">
                                    @if(isset($featured))
                                        @foreach($featured as $feat)
                                            @if($variant['sku'] != $feat['base_variant']['sku'])
                                                <div class="row frequently-bought-image-flex-style">
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                    <img class="img-responsive frequently-bought-product-size" src="{{ $renderer->assetExists($feat['base_variant']['assets'], 'primary_image', 'image', 0) }}">
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 no-gutter">
                                                    <p class="frequently-bought-product-name">{{ $feat['base_variant']['name'] }}<br />
                                                    @if($feat['base_variant']['msrp'] > $feat['base_variant']['price'])
                                                        <span><strike class="original-price-styling">${{ $feat['base_variant']['msrp'] }}</strike></span>&nbsp;<span>{{ $feat['base_variant']['price'] }}</span>
                                                    @else
                                                        <span>{{ $feat['base_variant']['price'] }}</span>
                                                    @endif
                                                    </p>
                                                    <div class="row mobile-add-view-button-margin">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left no-gutter">
                                                            <div class="col-xs-12 col-sm-6">
                                                                <a href="/cart/?_add={{ $feat['base_variant']['sku'] }}" class="block-button add-to-cart-button mobile-button-size" data-add-cart-modal-button="{{ $feat['base_variant']['sku'] }}" class="add-to-cart-button">ADD TO CART</a>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6">
                                                                <a href="/shop/product/{{ $feat['slug'] }}/#{{ $feat['base_variant']['sku'] }}" class="block-button view-product-button mobile-button-size">VIEW PRODUCT</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    </div>
                                    <div class="modal-footer remove-border">
                                      <p class="text-center"><a href="/cart" class="add-to-cart-modal-link">No Thanks, Continue to checkout.</a></p>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                </div>
                @endif
            </form>
            @endforeach
            </div>
            <div class="container">
                <img class="img-compare" src="/images/compare.jpg" />
            </div>
        </div>
        <!--Product section coding ends here-->
        <!-- Middle section coding ends here-->
        <!--CSS SPINNER -->
        <div class="loadingoverlay" style="display: none;"></div>
   @stop

   @section('sub-footer')

   @stop

@section('styles')
<link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" type="text/css" />
@stop

@section('lib-scripts')
    <script type="text/javascript" src="{{ asset('js/libs/owl.carouselbeta.min.js') }}"></script>
@stop


@section('scripts')
<script>
(function(window){
    var jQuery = window.jQuery || window.$ || {};
    var $ = jQuery;

    $(document).ready(function () {
        if ( $(".product_offer").length ) {
            $("#variant-subtitle").hide();
        };
    });

    $("")

    function owlres() {
        var $carousel = $('.sync1');
        $carousel.data('owl.carousel')._invalidated.width = true;
        $carousel.trigger('refresh.owl.carousel');
    }

    function initSliders() {
        $(".product-slider").each(function () {
            var $sync1 = $(this).find(".sync1");
            var $sync2 = $(this).find(".sync2");
            var flag = false,
                    duration = 300;

            $sync1.owlCarousel({
                items: 1,
                nav: false,
                dots: true,
                autoplay: true,
                afterInit: function () {
                }
            });

            $sync1.on('translated.owl.carousel', function (e) {
                var finalindex;
                if (e.item.index - 2 >= e.item.count) {
                    finalindex = 0;
                } else {
                    finalindex = e.item.index - 2;
                }
                $sync2.find(".owl-item").removeClass("activee");
                $sync2.find(".owl-item").eq(finalindex).addClass('activee');
                $sync2.trigger('to.owl.carousel', [finalindex, duration, true]);
            });

            $sync2.owlCarousel({
                items: 3,
                margin: 30,
                nav: false,
                center: false,
                dots: false,
                autoplay: false,
                responsive: {
                    0: {
                        items: 2,
                        margin: 10
                    },
                    480: {
                        items: 3,
                        margin: 10
                    },
                    640: {
                        items: 3,
                        margin: 15
                    },
                    768: {
                        items: 3,
                        margin: 10
                    },
                    992: {
                        items: 3,
                        margin: 20
                    },
                    1200: {
                        items: 3,
                        margin: 30
                    }
                },
                afterInit: function (e) {

                }
            });

            $sync2.on('click', '.owl-item', function () {
                $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
            });

            $sync2.on('change.owl.carousel', function (e) {
                if (e.namespace && e.property.name === 'items' && !flag) {
                    flag = true;
                    $sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                    flag = false;
                }
            });
            $sync2.find(".owl-item").eq(0).addClass("activee");
        });
    }

    function makeActive($elm) {
        // set the min height of container to height brefore switching
        var $section =  $('.product-section');
        $section[0].style.minHeight = $section.height();
        $('.item-product').removeClass('active').addClass('inactive');
        $elm.prependTo($elm[0].parentNode);
        $elm.removeClass('inactive').addClass('active');
        // resizeSoldOutImage();
    }

    function facebook_view (getPrice, getSku){
        // console.log('View Product')
        var fbq = window.fbq || function() {};
        var content_ids = [];
        content_ids.push(getSku);

        // console.log(getSku,getPrice);
        fbq('track', 'ViewContent', {
            'content_type': 'product',
            'content_ids': content_ids,
            'value': getPrice,
            'currency': 'USD'
        });
    }

    function facebook_addtocart(getSku, getPrice){
    // console.log('Add Product')
        var content_ids = [];
        var fbq = window.fbq || function() {};
        content_ids.push(getSku);
        // console.log(getSku,getPrice);
        fbq('track', 'AddToCart', {
          'content_type': 'product',
          'content_ids': content_ids,
          'value': getPrice,
          'currency': 'USD'
        });
    }
    function onProductSelect(e) {
        $(".showOnlyForFeaturedProduct").hide();
        var $this = $(this).parents('form');
        $this.find(".showOnlyForFeaturedProduct").show();
        window.location.hash = $this.data('product-sku');
    }

    function selectProduct(hash) {
        hash = hash.replace(/^#/, '');
        var $this = $('.item-product[data-product-sku="'+hash+'"]');
        var getPrice = $this.data('product-price');
        facebook_view(getPrice,hash);
        var $active = $('.item-product.active');
        if ($this[0] !== $active[0]) {
            $('.item-product')
            .velocity({opacity: 0}, {
                duration: 0,
                complete: function () {
                    makeActive($this);
                }
            }).velocity({opacity: 1}, {
                easing: 'easOutQuint',
                complete: function () {
                    owlres();
                }
            });

            if (navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/)) {
                $('body').animate({ scrollTop: $('body').offset().top }, 'slow');
            } else {
                $('body').animate({ scrollTop: $('h1').offset().top }, 'slow');
            }
        }
    }

    function getActiveProductHash() {
        var hash = window.location.hash.replace(/^#/, '');
        var $active = hash && $('.item-product[data-product-sku="'+hash+'"]');

        if (!$active) {
            hash = $('.item-product.active').data('product-sku');
            window.location.hash = '#'+hash;
        }

        return hash;
    }

    function onHashChanged(e) {
        // console.log('onHashChanged');
        var hash = getActiveProductHash()
        selectProduct(hash);

    }

    function bindDomEvents() {
        // Bind hash changes to
        $(window).on('hashchange', onHashChanged);
        $('.product-section').on('click', '.btn-secondary', onProductSelect);
    }


    function init() {
        initSliders();
        bindDomEvents();
        owlres();
        onHashChanged();

    }

    $(init);

    var variantTitle = $('#variant-title').text();

    var titleSubtitle = variantTitle.slice(variantTitle.indexOf("w/"), variantTitle.length);

    if(titleSubtitle.length > 1){
        $('#variant-subtitle').text(titleSubtitle);
        var newTitle = variantTitle.substring(0, variantTitle.indexOf("w/"));
        $('#variant-title').text(newTitle);
    }

    if($.trim( $(".short").html() ) ) {
        $('.read-more').show();
    }

    $('.read-more').on('click', function(){
        $(this).prev().removeClass('short').addClass('long');
        $(this).hide();
    })

    $('.text').on('click', function(){
        $(this).addClass('short')
        $('.read-more').show();
    })

    // $('.add-to-cart-button').click(function(){
    //     var button = $(this);
    //     var sku = button.data('add-cart-modal-button');
    //      $.ajaxSetup({
    //         headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')}
    //     });
    //      $.ajax({
    //         type: 'POST',
    //         url: '/cart',
    //         data: {
    //             '_add': sku
    //         }
    //      })
    //      .done(function(data){
    //         if(data.success){
    //             $('.cart-items-count').text(data.itemsCount);
    //         }
    //      })
    //      .fail(function(error){
    //         console.log('Something went wrong please try again later');
    //      });
    //      return false;
    // });

    //TRIGGERS AFTER CLICKING ADD TO CART BUTTON
    $(".button-call-ajax").click(function(){
        var getSku;
        var getPrice;
        getPrice = $(this).parents('form').data('product-price');
        getSku = $(this).parents('form').data('product-sku');
        getImage = $(this).parents('form').find('.main-actions .product-slider img').first();
        var getImageLink = getImage.prop('src');
        var getProductTitle = $(this).parents('form').find('.main-actions .product-details .product-title h2').text();
        ajaxRun(getSku, getImageLink, getProductTitle);
        facebook_addtocart(getSku, getPrice);
    });

    function ajaxRun(getSku, getImageLink, getProductTitle){
        $('#cart-post-index.'+getSku).submit(function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')}
        });
        $(".loadingoverlay").show();
        var form = $(this);
        var url = form.prop('action');
        var method = 'POST';
        var variantSku = form.find('input[name="_add"]').val();
        $.ajax({
            type: method,
            url: url,
            data: {
                '_add': variantSku
            }
        })
        .done(function(data){
            $(".loadingoverlay").hide();
            if(data.success){
                $('.image-holder img').attr('src', getImageLink);
                $('.added-product-heading').text(getProductTitle);
                $('#addToCartModal').modal('show');
                $('.cart-items-count').text(data.itemsCount);
            }
        })
        .fail(function(error){
            console.log('an error ocurred please try again later.');
        });
        return false;

    });
}

$('.notify-button').click(function(){
    $('#cart-post-index').submit(function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')}
        });
        if($('#out-of-stock-email').length){
            $.ajax({
                type: 'POST',
                url: '/outofstock',
                data: {
                    'email': $('#out-of-stock-email').val(),
                    'variant_sku': window.location.hash.substring(1),
                    'product_url': window.location.href
                }
            })
            .done(function(data){
                if(data.success){
                    $('#notify-error').hide();
                    $('#out-of-stock-email').val('');
                    $('#notify-success').text(data.success).show();
                }
            })
            .fail(function(error){
                var errorText = JSON.parse(error.responseText);
                 $('#notify-success').hide();
                 $('#notify-error').text(errorText.email[0]).show();
            });
            return false;
        }
    });
});
})(window);
$(window).load(function () {
    //HIDE ALL OUT OF STOCK FORM
    $('.showOnlyForFeaturedProduct').hide();
    //SHOW FOR THE ACTIVE PRODUCT ON DOCUMENT LOAD
    $(".container").find("#cart-post-index.active").find('.showOnlyForFeaturedProduct').show();
});
</script>
@stop

@section('title'){{ $variant['name'] }}@stop
@section('description'){{ $renderer->htmlText('', $variant, 'description', 'text') }}@stop
