<!-- Feature links section coding starts here-->
<div class="col-xs-12 col-sm-4 pull-right">
    <h3 class="hidden-xs">
        FEATURED LINKS
        <small>Bookmark These!</small>
    </h3>
    <ul class="btn-links">
    @if(isset($featuredLinks))

       @foreach($featuredLinks as $index => $link)
            <li><a href="{{ url('shop/product/'.$link['slug']) }}" title="{{ $link['name'] }}">{{ $link['name'] }}</a></li>
       @endforeach
    @endif
    </ul>
</div>
<!-- Feature links section coding ends here-->