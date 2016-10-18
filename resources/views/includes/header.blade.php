@inject('shopping_cart', 'Flavorgod\Http\Services\ShoppingCart')
<header class="header-main">
    <div class="container container-lg hidden-xs">
        <ul class="login-detail">
            @if($signedIn)
            <li class="manage-acc"><a href="{{ url('members/profile') }}" title="Welcome Back {{ $user->first_name }}">Welcome Back {{ $user->first_name }}</a></li>
            <li><a href="{{ url('/auth/logout') }}" title="LOGOUT">LOGOUT</a></li>
            @else
            <li><a href="#" title="LOGIN" data-toggle="modal" data-target="#modalLogin" class="auth-link">LOGIN</a></li>
            <li><a href="#" title="SIGN UP" data-toggle="modal" data-target="#modalSignup" class="auth-link">SIGN UP</a></li>
            @endif
        </ul>
    </div>
    <div class="container container-lg">
        <!-- Menu coding starts here-->
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed toggle-menu menu-left" data-toggle="collapse" data-target="#navbar-collapse-main" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-fw fa-bars"></i>
                    <span class="menu-text hidden-lg hidden-md hidden-sm">Menu</span>
                </button>
                <a href="{{ url('/cart') }}" class="navbar-toggle collapsed menu-right" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="menu-text hidden-lg hidden-md hidden-sm">Cart</span>
                </a>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="hidden-xs" src="https://s3.amazonaws.com/dash.flavorgod.com/assets/logo.png" alt="Flavor God" title="Flavor God" />
                    <img class="visible-xs" src="https://flavorgod.s3.amazonaws.com/homepage/logo-mobile.png" alt="Flavor God" title="Flavor God" />
                </a>
            </div>

            <div class="collapse navbar-collapse cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="navbar-collapse-main">
                <a href="{{ url('') }}" class="menu-close hidden-lg hidden-md hidden-sm">
                    <i class="fa fa-fw fa-bars"></i>
                    <span>Return To Site</span>
                </a>
                <a href="{{ url('') }}" class="menu-logo hidden-lg hidden-md hidden-sm">
                    <img src="https://flavorgod.s3.amazonaws.com/homepage/logo-mobile.png" alt="Flavor God" />
                </a>
                <ul class="nav navbar-nav nav-main">
                    <li class="dropdown {{ $viewName == 'storeindex'? 'active': '' }}">
                        <a href="{{ url('/shop#') }}" title="SHOP" class="dropdown-toggle disabled nav-icon1" data-toggle="dropdown" data-hover="dropdown" aria-expanded="false">Shop</a>
                        @if(count($productCategories))
                        <ul class="dropdown-menu" role="menu">
                            @foreach($productCategories as $category)
                            <li><a href="{{ url('shop#'.$category['slug']) }}" title="{{ $category['name'] }}" class="sub-icon1">{{ $category['name'] }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    <li class="{{ $viewName == 'homeabout'? 'active': '' }}"><a href="{{ url('/about') }}" title="ABOUT" class="nav-icon2">About</a></li>
                    <li class="{{ $viewName == 'homereviews'? 'active': '' }}"><a href="{{ url('/reviews') }}" title="REVIEWS" class="nav-icon3">Reviews</a></li>
                    <li class="{{ $viewName == 'homefaqs'? 'active': '' }}"><a href="{{ url('/faqs') }}" title="FAQS" class="nav-icon4">FAQS</a></li>
                    <li class="{{ $viewName == 'homevip'? 'active': '' }}"><a href="{{ url('/vip') }}" title="VIP LIST" class="nav-icon5 ">VIP LIST</a></li>
                    <li class="{{ $viewName == 'homecontact'? 'active': '' }}"><a href="{{ url('/contact') }}" title="CONTACT" class="nav-icon6">Contact</a></li>
                    <li class="nav-viewcart">
                        <ul class="nav navbar-nav navbar-right nav-cart hidden-xs">
                            <li><a href="{{ url('/cart') }}" class="btn btn-outline" title="View Cart"><span class="text">View Cart</span> <i class="fa fa-fw fa-shopping-cart"></i> <span class="count bounce animated cart-items-count">{{ $shopping_cart->getCartQuantity() }}</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Shopping Cart -->
            <div class="collapse navbar-collapse cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="navbar-collapse-cart">
                <div class="menu-header">
                    <a href="#" class="menu-close-cart hidden-lg hidden-md hidden-sm">
                        <i class="fa fa-fw fa-list"></i>
                        <span>Continue Shopping</span>
                    </a>
                </div>
                @if(count($shopping_cart->getCart()['items']))
                <div class="cart-filled">
                    <ul class="quick-cart">
                        @foreach($shopping_cart->getCart()['items'] as $item)
                        <li>
                            <div class="quick-cart-img">
                                <img src="{{ $item['assets']['primary_image']['path'] }}" alt="" />
                            </div>
                            <div class="quick-cart-dtl">
                                <p><strong>{{ $item['quantity'] }}X {{ $item['name'] }}</strong></p>
                                <p>${{ number_format($item['total'], 2) }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                </div>
                @else
                <div class="cart-empty">
                    <p>
                        Your Cart Is Currently Empty
                    </p>
                </div>
                @endif
            </div>
            <!-- End Shopping Cart -->
        </nav>
        <!-- Menu coding end here-->
    </div>
</header>
@if(!empty(Input::get('coupon')))
<script type="text/javascript"> 
    (function(){
            function addCouponFromUrl(){
                var url = '{{ url() }}'+'/cart?coupon='+'{{ Input::get('coupon') }}';
                var method = 'GET';
                jQuery.ajax({
                     type: method,
                     url:  url
                });
            }

            addCouponFromUrl();
    })();
</script>        
@endif
@section('header-banner')
    @include('includes.banner')
@show
