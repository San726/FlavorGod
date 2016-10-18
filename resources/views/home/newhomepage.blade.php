@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')

@extends('app')

@section ('title')
Home of FRESH & Healthy Seasonsings
@stop

@section ('description')
Checkout our Healthy, Paleo Seasonings, GMO & MSG Free Seasonings made FRESH by Chris Wallace - Flavorgod.
@stop

@section ('keywords')
flavorgod, paleo seasoning, gmo free seasoning, msg free seasoning, vegan seasoning
@stop

@section('bodyClass')
index homepage2
@stop

@section('header-banner')
    @include('includes.slidebanner')
@stop

@section('content')

    <div class="index-wrapper">
        <!--Service section coding start here-->
        <div class="sec-services">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="service-single">
                            <img src="{{ asset('images/icon-shipping.png') }}" alt="" />
                            <h3>
                                <strong>FREE SHIPPING FOR</strong><br/>
                                USA Orders $50+
                            </h3>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="service-single">
                            <img src="{{ asset('images/icon-free.png') }}" alt="" />
                            <h3>
                                <strong>PALEO,</strong> GMO, &<br/>
                              MSG FREE SEASONINGS
                            </h3>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="service-single">
                            <img src="{{ asset('images/icon-support.png') }}" alt="" />
                            <h3>
                                <strong>24/7</strong> Customer<br/>
                                Support
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Service section coding ends here-->
        <!--Offer section coding start here-->
        <div class="sec-offer">
            <div class="offer-bg">
                <div class="bg-left"></div>
                <div class="bg-right"></div>
            </div>
            <div class="offer-content">
                <div class="offer-content-inner">
                    <div class="container container-lg">
                        <div class="row">
                            <div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-0">
                                <a href="{{ url('about')}}" class="offer-left" title="ABOUT FLAVORGOD">
                                    <h2>Learn More</h2>
                                    <h3>About Flavorgod</h3>
                                </a>

                            </div>
                            <div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-0">
                                <a href="{{ url('reviews')}}" class="offer-right" title="CUSTOMER REVIEWS">
                                    <h2>Reviews</h2>
                                    <h3>Check our customer reviews</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Offer section coding ends here-->
        <!--Product section coding start here-->

        <div class="sec-product">
            <div class="container store-details">
                <div class="mobile-dropdown-search visible-xs">
                    <form action="#" class="input-group">
                        <input placeholder="Looking for…" class="form-control">
                        <div class="input-group-btn">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>

                <div class="sec-product-filter">
                    <div class="dropdown-nav-holder">
                        <span class="text-box">All2</span>
                        <a href="#" class="opener">
                            <i class="fa fa-angle-down"></i>
                            <i class="fa fa-angle-up"></i>
                        </a>
                        <ul class="nav" style="display: none;">
                          @foreach($productSets as $set)
                          <li role="presentation" @if($set['slug']!='all') data-filter="#{{ $set['slug'] }}" class="active" @else data-filter="#" @endif style="display:none"><a href="#{{ $set['slug'] }}">{{ $set['name'] }}</a></li>
                          @endforeach
                          <li role="presentation" class="search-box-holder">
                            <a href="#" data-toggle="dropdown" class="search-toggle"><i class="fa fa-search"></i></a>
                          </li>
                        </ul>
                    </div>
                </div>

                <div class="dropdown-search hidden-xs" style="display: none;">
                    <form action="/shop" class="input-group">
                        <input placeholder="Looking for..." name="search" class="form-control">
                        <div class="input-group-btn">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>

                <div class="product-slider-main-holder">
                    @foreach($productSets as $productSet)
                    <div class="product-slide-box">
                        <div id="{{ $productSet['slug'] }}" class="header">
                            <h3>{{ $productSet['name'] }}</h3>
                        </div>

                        <ul class="main-product-slider">
                            {{--  foreach starts here --}}
                            @foreach($productSet['products'] as $product)

                                <li class="product-set" data-category-set="{{ implode(' ', @$product['product_sets']['category'] ?: []) }}">
                                    <!-- Featured free shipping -->
                                    <div class="featured-campaign">
                                        @if(count(@$product['product_sets']['flags']))
                                            @if(in_array('limited-stock', $product['product_sets']['flags']))
                                                <div class="limited-stock">
                                                    <i class="fa fa-clock-o"></i>
                                                    Limited Stock!
                                                </div>
                                            @elseif(preg_match('/(\d+)-days?-left/', implode(' ', $product['product_sets']['flags']), $m))
                                                <div class="limited-stock">
                                                    {{ $m[1] }} DAYS LEFT!
                                                </div>
                                            @endif
                                            @if(in_array('last-day', $product['product_sets']['flags']))
                                                <div class="limited-stock">
                                                Last Day!
                                                </div>
                                            @endif
                                            @if(in_array('free-shipping', $product['product_sets']['flags']))
                                                <div class="free-shipping">
                                                    <i class="fa fa-truck fa-flip-horizontal"></i>
                                                    <strong>Free shipping</strong> 1 day only
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="prod-single prod-red">
                                        <a href="/shop/{{ !empty($product['slug'])? 'product/'.$product['slug'].'/#'.$product['base_variant']['sku']: 'product/'.$product['id']}}" class="prod-img" title="{{ $product['base_variant']['name'] }}">
                                            <div class="dis-table">
                                                <div class="dis-table-cell">
                                                    <img class="lazy" src="" data-original="{{ $renderer->assetExists($product['base_variant']['assets'], 'primary_image', 'image') }}" alt="{{ @$product['base_variant']['name'] }}" title="{{ @$product['base_variant']['name'] }}" />
                                                    <div class="prod-overlay">
                                                        <div class="dis-table">
                                                            <div class="dis-table-cell">
                                                                <p>
                                                                    <img src="{{ asset('images/prod-hover.png') }}" alt="click to Learn More" title="click to Learn More" />
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
                                                    <img src="{{ $renderer->assetExists($product['assets'], 'icon_circle', 'image') }}" alt="{{ @$product['base_variant']['name'] }}" title="{{ @$product['base_variant']['name'] }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prod-descr">
                                            <h2><a href="/shop/{{ !empty($product['slug'])? 'product/'.$product['slug'].'/#'.$product['base_variant']['sku']: 'product/'.$product['id']}}" class="prod-img" title="{{ $product['base_variant']['name'] }}">{{ $product['base_variant']['name'] }}</a></h2>
                                            <h3>
                                                @if($product['base_variant']['msrp'] > $product['base_variant']['price'])
                                                <small>${{ number_format($product['base_variant']['msrp'], 2) }}</small>
                                                @endif
                                                <span>${{ number_format($product['base_variant']['price'], 2) }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            {{-- foreach ends here --}}
                        </ul>
                    </div>
                    @endforeach

                </div>


            </div>
        </div>
        <!--Product section coding ends here-->
        <!--Learn section coding starts here-->
        <div class="sec-learn hidden-xs">
            <div class="dis-table">
                <div class="dis-table-cell">
                    <div class="container">
                        <h2>LEARN ABOUT OUR <strong>UNIQUE BLENDS</strong></h2>
                        <ul>
                            @foreach($productCategories as $category)
                                <li><a href="{{ url('/shop/#' . $category['slug']) }}" title="{{ $category['name'] }}">{{ $category['name'] }}</a></li>
                            @endforeach
                        </ul>
                        <a href="{{ url('shop')}}" class="btn btn-outline">ENTER STORE</a>
                    </div>
                </div>
            </div>
            <div class="side-img side-left">
                <img src="{{ url('images/img-learn-left.png') }}" alt="" />
            </div>
            <div class="side-img side-right">
                <img src="{{ url('images/img-learn-right.png') }}" alt="" />
            </div>
        </div>
        <!--Learn section coding starts here-->
        <!--Join section coding starts here-->
        <div class="sec-join">
            <div class="container">
                <div class="join-intro">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>
                                My mission is and always will be to <strong>provide people with unique and delicious seasonings</strong>
                                that help them create amazing meals everyday in kitchens all around the world.
                            </h3>
                        </div>
                        <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <h6>
                                Thank you to all of our fans, customers, and affiliates for supporting us in
                                our journey to share our seasonings across the world!
                            </h6>
                        </div>
                    </div>
                </div>
         <!--       CTA Banner coding start here -->
                <div class="adv-offer">
                    <a href="{{ url('vip') }}">
                        <h4>JOIN THE <span class="circle">VIP</span> LIST &amp; GET EARLY ACCESS TO NEXT MONTH's NEW FLAVOR</h4>
                    </a>
                </div>
         <!--  CTA Banner coding ends here -->
            </div>
        </div>
    </div>

@stop

@section('sub-footer')
    @include('components.instagram-feed')
    @include('components.footer-logo')
    @include('components.footer-vip-signup')
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" type="text/css" />
@stop

@section('modals')
    @include('components.viplist-modal')
@stop

@section('lib-scripts')
<script src="{{ asset('js/libs/owl.carousel.min.js') }}" type="text/javascript"></script>
@stop

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>

<script>
(function (window, undefined){
    var $ = window.jQuery || window.$ || {};
    var document = window.document;
    var productSets = {!! json_encode($productSets) !!};

    var filters = $.map(productSets, function (productSet) {
        return productSet.slug;
    });

    function filterProducts(filter, animate) {
        var $active;
        var $removed;
        $('.sec-product-filter li[data-filter]').removeClass('active');
        if (filter && filters.length && filters.indexOf(filter) >= 0) {
            $active = $('li[data-category-set~="'+filter+'"]');
            $('.sec-product-filter li[data-filter="#'+filter+'"]').addClass('active');
        } else {
            $('.sec-product-filter li[data-filter="#"]').addClass('active');
            $active = $('li[data-category-set]');
        }

        // $('li[data-category-set]').hide();
        animate = (typeof animate === 'undefined') ? true : animate;
        if (animate) {
            $active.velocity('fadeIn', {display: 'inline-block', stagger: 30, drag: true});
        } else {
            $active.show();
        }

        return $active;
    }

    function onSelectFilter(e) {
        var filter = this.hash.replace(/^#/, '');
        // location.hash = filter;
        console.log(this.hash);
        $(document.body).animate({
            'scrollTop':   $(this.hash).offset().top
        }, 500);
        filterProducts(filter);

        if (e && e.preventDefault) {
            e.preventDefault();
            e.returnValue = false;
        }
    }

    function initProuctDisplay() {
        // Hide all items by default
        $('[data-filter]').on('click', 'a', onSelectFilter);

        filterProducts('');
    }

    function showFilters() {
        var $activeFilters = $();

        for (var i = 0, len = filters.length; i < len; i++) {
            if ($('li[data-category-set~="'+filters[i]+'"]').length) {
                $activeFilters = $activeFilters.add($('.sec-product-filter li[data-filter="#'+filters[i]+'"]'));
            }
        }

        $activeFilters.show();
    }

    function initOwlSlider() {
        $("#owl-demo1").owlCarousel({
            items: 1,
            nav: true,
            dots: false,
            loop: true,
            autoplay: true,
            smartSpeed: 4000
        });

        //For Slider
        if ($('.owlslider').length > 0) {
            $('.owlslider').owlCarousel({
                autoplay: true,
                items: 1,
                nav: false,
                dots: true,
                //pagination: true,
                navText: "",
                loop: true,
                responsiveClass: true,
                smartSpeed: 1300,
                responsive: {
                    320: {
                        items: 1
                    },
                    480: {
                        items: 1
                    },
                    767: {
                        items: 1
                    },
                    1092: {
                        items: 1
                    }
                }
            });
        }

        //For Slider
        if ($('.main-product-slider').length > 0) {
            $('.main-product-slider').owlCarousel({
                autoplay: false,
                nav: true,
                dots: false,
                navText: "",
                responsiveClass: true,
                smartSpeed: 200,
                center: true,
                stagePadding: 0,
                responsive: {
                    480: {
                        stagePadding: 40,
                        loop: true,
                        center: true,
                        items: 1,
                        slideBy: 1,
                    },
                    768: {
                        stagePadding: 0,
                        center: false,
                        loop: false,
                        items: 2,
                        slideBy: 2,
                    },
                    992: {
                        stagePadding: 0,
                        center: false,
                        loop: false,
                        items: 3,
                        slideBy: 3,
                    },
                    1200: {
                        stagePadding: 0,
                        center: false,
                        loop: false,
                        items: 4,
                        slideBy: 4,
                    }
                }
            }).on('translated.owl.carousel', function(event) {
                $("img.lazy").trigger("scroll");
            });
        }
    }

    function init() {
        initProuctDisplay();
        initOwlSlider();
        showFilters();
    }

    function initCategoryDropdown() {
        $('.dropdown-nav-holder').each(function () {
            var holder = $(this);
            var opener = holder.find('.opener');
            var textHold = holder.find('.text-box');
            var searchOpener = holder.find('.search-toggle');
            var searchDropBox = $('.dropdown-search');

            var navBox = holder.find('ul');
            opener.on('click', function(e){
                e.preventDefault();
                opener.toggleClass('active');
                navBox.slideToggle(400);
            });

            navBoxLinks = navBox.find('a:not(.search-toggle)');

            searchOpener.on('click', function(e) {
                e.preventDefault();
                searchDropBox.slideToggle(400);
                navBox.find('li').toggleClass('remove-border');
            });

            navBoxLinks.each(function(){
                $(this).on('click', function(e) {
                    e.preventDefault();
                    var newText = $(this).text();
                    textHold.text(newText);
                    searchDropBox.slideUp(400);
                    navBox.find('li').removeClass('remove-border');
                });
            });
        });
    }

    function initLazyLoading(){
        $("img.lazy").lazyload({
            event : "scroll"
        });
    }

    $('li[data-category-set]').hide();
    $(init);

    $(document).ready(function() {
        initCategoryDropdown();

        initLazyLoading();

        $('.slide-link').on('click', function(event){
            var $this = $(this);
            if($this.hasClass('clicked')){
                $this.removeAttr('style').removeClass('clicked');
            } else{
                $this.addClass('clicked');
                $(this).attr('href', $(this).attr('data-href'));
            }
        });
    });
})(window);
</script>
@stop
