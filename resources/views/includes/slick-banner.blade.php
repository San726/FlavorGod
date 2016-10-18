<!--Inner Banner section coding starts here-->
<div class="slick-banner">
    <div class="top-alert">
        <h3>FREE SHIPPING ON ALL USA ORDERS OVER $50</h3>
    </div>
    <div class="slider hidden-xs">
    @if(isset($store))
        @foreach($store->assets as $asset)
            @if($asset->pivot->getAttribute('relation_type_name') == 'slider_image')
                <a data-href="/shop/product/{{ $asset->name }}" class="">
                     <img style="width:100%; max-height:640px;" class="img-responsive" data-lazy="{{ $asset->path }}"  alt="{{ $asset->description }}" title="">
                </a>
            @endif
       @endforeach
    @endif
    </div>
    <div class="slider visible-xs">
    @if(isset($store))
        @foreach($store->assets as $asset)
            @if($asset->pivot->getAttribute('relation_type_name') == 'Mobile Slider Image')
                <a data-href="/shop/product/{{ $asset->name }}" class="">
                    <img style="width:100%; max-height: 640px;" class="img-responsive" data-lazy="{{ $asset->path }}"  alt="{{ $asset->description }}" title="">
                </a>
            @endif
       @endforeach
    @endif
    </div>
</div>
<!--Inner Banner section coding ends here-->


