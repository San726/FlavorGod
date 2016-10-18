@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')
@section('content')
<!--stores section coding starts here-->
<div class="store hidden-xs">
        <div class="product-filters">
            <div class="product-categories">
                <h3 class="product-category active" data-filter="#">
                    All Products
                </h3>
                @foreach($productSets as $set)
                    <h3 class="product-category" data-filter="#{{ $set['slug'] }}">
                        {{ $set['name'] }}
                    </h3>
                @endforeach
                <h3 class="product-category active product-search-trigger">

                    <a class="product-search-icon">
                        <span class="glyphicon glyphicon-search"></span>
                    </a>
                    <form class="form-inline search-form" role="form" id="" style="display: none" action="">
                        <div class = "input-group">
                           <input type = "text" class="form-control" name="search" placeholder="Looking for..." autofocus>
                           <span class = "input-group-btn">
                              <button class = "btn btn-sm" type="submit">
                                 Go!
                              </button>
                           </span> 
                        </div><!-- /input-group -->
                    </form>
                </h3>

            </div>
        </div>
</div>
@if(!empty($search))
<div class="store hidden-xs">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="searched-keywords">
        <p>Showing Results For:&nbsp;<span>{{ $search }}&nbsp;- ( {{ $results_number }} items )&nbsp;<a href="shop"><i class="fa fa-close remove-search-results"></i></a><span></span></span></p></div>
    @if($results_number==0)
    <div class="alert alert-warning" role="alert">
      <strong>Sorry!</strong> No results found. Please try a different search or take a look at our popular items:
    </div>
    @endif
    </div>
</div>
@endif
<div class="store-details">
    <div class="container">
        <div class="sec-product-filter visible-xs">
            <ul class="nav nav-pills">
                <li>
                        <a class="product-search-icon-mobile">
                            <input type="text" name="" placeholder="Search" />
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                </li>
                <li role="presentation" data-filter="#"><a href="#">All Products</a></li>
                @foreach($productSets as $set)
                <li role="presentation" data-filter="#{{ $set['slug'] }}" style="display:none"><a href="#{{ $set['slug'] }}">{{ $set['name'] }}</a></li>
                @endforeach
                <!--<li role="presentation" data-filter="#" class="active"><a href="#">All</a></li>-->
                <!--<li role="presentation" data-filter="#featured-combo-packs"><a href="#featured-combo-packs">Combo</a></li>-->
                <!--<li role="presentation" data-filter="#flavorgod-seasonings"><a href="#flavorgod-seasonings">Classic</a></li>-->
                <!--<li role="presentation" data-filter="#brand-new-paleo-jerky"><a href="#brand-new-paleo-jerky">New</a></li>-->
            </ul>
        </div>
        <div class="sec-product">
            <ul class="row">
                @foreach($products as $product)
                <li class="col-sm-6 col-md-3 product-set" data-category-set="{{ implode(' ', @$product['product_sets']['category'] ?: []) }}" data-flags-set="{{ implode(' ', @$product['product_sets']['flags'] ?: []) }}" style="display:none">
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
                                    <img src="{{ $renderer->assetExists($product['base_variant']['assets'], 'primary_image', 'image') }}" alt="{{ @$product['base_variant']['name'] }}" title="{{ @$product['base_variant']['name'] }}" />
                                    <div class="prod-overlay">
                                        <div class="dis-table">
                                            <div class="dis-table-cell">
                                                <!--[ Hover ] Standard product-->
                                                <div class="hover-standard">
                                                    <p>
                                                        <img src="{{ asset('images/prod-hover.png') }}" alt="click to learn more" />
                                                        <span>click to Learn More</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!--Spicy icon-->
                        <div class="prod-cat">
                            <div class="dis-table">
                                <div class="dis-table-cell">
                                    <img src="{{ $renderer->assetExists($product['assets'], 'icon_circle', 'image') }}" alt="{{ @$product['base_variant']['name'] }}" title="{{ @$product['base_variant']['name'] }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="prod-descr">
                            <h2><a href="/shop/{{ !empty($product['slug'])? 'product/'.$product['slug'].'/#'.$product['base_variant']['sku']: 'product/'.$product['id']}}" class="prod-img" title="{{ $product['base_variant']['name'] }}">{{ @$product['base_variant']['name'] }}</a></h2>
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
            </ul>
        </div>
    </div>
</div>
<!--stores section coding ends here-->
@stop
@section('scripts')
<script>
    (function (window, undefined) {
        var $ = window.jQuery || window.$ || {};
        var document = window.document;
        var productSets = {!! json_encode($productSets) !!};
        var filters = $.map(productSets, function (productSet) {
            return productSet.slug;
        });
        function filterProducts(filter, animate) {
            var $active;
            var $removed;
            $('.product-categories h3[data-filter]').removeClass('active');
            $('.sec-product-filter li[data-filter]').removeClass('active');
            if (filter && filters.length && filters.indexOf(filter) >= 0) {
                $active = $('li[data-category-set~="'+filter+'"]');
                $('.product-category[data-filter="#'+filter+'"]').addClass('active');
                $('.sec-product-filter li[data-filter="#'+filter+'"]').addClass('active');
            } else {
                $('.product-category[data-filter="#"]').addClass('active');
                $('.sec-product-filter li[data-filter="#"]').addClass('active');
                $active = $('li[data-category-set]');
            }
            $('li[data-category-set]').hide();
            animate = (typeof animate === 'undefined') ? true : animate;
            if (animate) {
                $active.velocity('fadeIn', {display: 'inline-block', stagger: 30, drag: true});
            } else {
                $active.show();
            }
            return $active;
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
        function onHashChanged(e) {
            var filter = window.location.hash.replace(/^#/, '');
            filterProducts(filter, !!e);
        }
        $(function () {
            $('.product-category').on('click',function(){
                if(!$(this).hasClass('active'))
                window.location = $(this).attr('data-filter');
            });
    // Bind hash changes to
    $(window).on('hashchange', onHashChanged);
    });
            $(document).ready(function () {
                onHashChanged();
                showFilters();
            });
    // Hide all items by default
    $('li[data-category-set]').hide();
    // uncomment to make available to console
    window.filterProducts = filterProducts;

    $('.product-search-trigger').click(function(){
        if($('.search-form').is(':hidden')) $('.search-form').slideDown();
    })
    $(document).mouseup(function (e)
    {
        var container = $(".search-form");
        if (!container.is(e.target)
            && container.has(e.target).length === 0) 
        {
            container.slideUp();
        }
    });
    $('.product-search-icon-mobile .glyphicon-search').click(function(e){
        window.location = '/shop?search='+$('.product-search-icon-mobile input').val();
    })

    //show popular items if search don't find anything
    if({{ $results_number }} == 0){
         location.hash = '#popular-items';
    }
    //if search find something, remove any hash
    else if('{{ $search }}'){
        location.hash = '';
    }
})(window);
</script>
@stop
@section('title', 'Seasoning Shop Page for Combo Sets, Limited Edition, Classic & Recipes')
@section('description', 'Here, is where you buy Flavorgod FRESH and direct from the manufacturer, Chris Wallace!')
@section('keywords', 'buy seasonings, everything seasoning, flavorgod seasonings, where to buy flavorgod seasonings')
@section('scripts')
@append