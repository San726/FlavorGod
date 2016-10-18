<!--Inner Banner section coding starts here-->
<div class="banner">
    <div class="top-alert">
        <h3>FREE SHIPPING ON ALL USA ORDERS OVER $50</h3>
    </div>
    <ul class="owlslider hidden-xs">
    @if(isset($store))
       @foreach($store->assets as $asset)
            @if($asset->pivot->getAttribute('relation_type_name') == 'slider_image')
                <li>
                    <a data-href="/shop/product/{{ $asset->name }}" class="slide-link">
                        <!-- <img class="owl-lazy lazyOwl" data-src="https://s3.amazonaws.com/SHREDZ-SITE/SHREDZ.COM/Desktop-Banner-V3.jpg"> -->
                        <!-- <img class="img-responsive owl-lazy" data-src="{{ $asset->path }}"  alt="{{ $asset->description }}" title="" />  -->
                        <img class="img-responsive owl-lazy lazyOwl" data-src="{{ $asset->path }}"  alt="{{ $asset->description }}" title="">
                    </a>
                    <h1>{{ $asset->description }}</h1>
                </li>
            @endif
       @endforeach
    @endif
    </ul>
    <ul class="owlslider visible-xs">
    @if(isset($store))
       @foreach($store->assets as $asset)
        @if($asset->pivot->getAttribute('relation_type_name') == 'Mobile Slider Image')
            <li>
                <a data-href="/shop/product/{{ $asset->name }}" class="slide-link">
                    <!-- <img class="img-responsive owl-lazy lazyOwl" data-src="https://s3.amazonaws.com/SHREDZ-SITE/SHREDZ.COM/Desktop-Banner-V3.jpg" alt="{{ $asset->description }}" title="" /> -->
                    <img class="img-responsive owl-lazy lazyOwl"  data-src="{{ $asset->path }}" alt="{{ $asset->description }}"  title="" />
                </a>
                <h1>{{ $asset->description }}</h1>
            </li>
        @endif
       @endforeach
    @endif
    </ul>
</div>
<!--Inner Banner section coding ends here-->


