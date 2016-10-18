@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')
@section('content')
    <div class="sec-product">
        <div class="container">
            <ul class="row">
           {{--  foreach starts here --}}
            @foreach($products as $product)
                <li class="col-sm-6 col-md-4 col-lg-3" data-product-set="{{ implode(' ', $product['product_sets']) }}">
                    <div class="prod-single prod-red">
                        <a href="/shop/product/{{ $product['slug'] }}" class="prod-img" title="{{ $product['name'] }}">
                            <div class="dis-table">
                                <div class="dis-table-cell">
                                    <img src="{{ $renderer->assetExists($product['assets'], 'primary_image', 'image') }}" alt="{{ @$product['name'] }}" title="{{ @$product['name'] }}" />
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
                                    <img src="{{ $renderer->assetExists($product['assets'], 'icon_circle', 'image') }}" alt="{{ @$product['name'] }}" title="{{ @$product['name'] }}" />
                                </div>
                            </div>
                        </div>
                        <div class="prod-descr">
                            <h2><a href="product" title="{{ $product['name'] }}">{{ $product['name'] }}</a></h2>
                            <h3>
                                @if($product['base_variant']['msrp'] > $product['base_variant']['price'])
                                <small>${{ $product['base_variant']['msrp'] }}</small>
                                @endif
                                <span>${{ $product['base_variant']['price'] }}</span>
                            </h3>
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
            {{-- foreach ends here --}}

        </div>
    </div>
@stop