@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')
@section('title', 'VIP List - New seasoning updates and special discounts')
@section('description', 'Want to know when our New seasonings are releasing? Join our VIP list and be the first one to know. Exclusive Discounts availble.')
@section('keywords', 'discount codes, cheap flavorgod')

@section('content')
    <!--viplist section coding starts here-->
    <div class="viplist-section section">
        <div class="container">
            <div class="row white-bg">
                <div class="col-xs-12 col-lg-10 col-lg-offset-1 text-center">
                    <p>Want to get your hands on the next <span>new exclusive</span> flavor release <span>before anyone else?</span> <em>Sign up for our FREE newsletter today and you’ll always hear about the next launch days before the public!</em></p>

                </div>

            </div>
            <!--vipform coding starts here-->
            <div class="row viplist-form">
                <div class="col-xs-12 pdlf0">
                    <h5>sign me up up for <span>the VIP LIST</span></h5>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                             <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="/vip" novalidate>
                         {!! csrf_field() !!}
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="txtemail" placeholder="Example@gmail.com">
                        </div>
                        <div class="form-group form-group-btn">
                            <button type="submit" class="btn btn-default btn-block" title="JOIN NOW">join now</button>
                        </div>
                    </form>

                    <div class="subscribe">
                        <p class="text-center">
                            <strong>monthly subscribers get special deals weekly that will benefit their purchase!</strong> <br/>
                            all subscribers can easily be taken off the mailing list with a simple click of a button!
                        </p>
                    </div>
                    <!--CTA Banner coding start here-->
                    <div class="adv-offer">                                           
                         @if(isset($store))
                           @foreach($store->assets as $asset)
                                @if($asset->pivot->getAttribute('relation_type_name') == 'faq_banner_link')
                                    {{ $renderer->storeHtmlText('<a><h4>', $asset->path) }}
                                @endif
                           @endforeach
                        @endif                    
                    </div>
                    <!--CTA Banner coding ends here-->
                </div>
            </div>
            <!--vipform coding ends here-->

        </div>
    </div>
@stop