@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

<?php $titleClass = "profile-title has-bg" ?>

@section('title', 'Vip List')
@section('description', 'Find out how its possible to Paleo Seasoning, GMO Free, MSG Free and delicious flavoring all packed in one bottle!')
@section('keywords', 'paleo, msg free, seasoning, who is chris wallace, chris wallace, healthy seasonings')
@section('content')
    <header class="profile-header">
        <div class="profile-links">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">My Account</a></li>
                    <li class="active"><a href="#">Refer-A-Friend</a></li>
                </ol>
                <a href="#" class="logout">logout <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
        <div class="tabs-box">
            <div class="container">
                <ul class="profile-tab">
                    <li><a href="#">profile</a></li>
                    <li><a href="#">my orders</a></li>
                    <li class="active"><a href="#">refer-a-friend</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="profile-meta">
            <div class="pic">
                <img src="{{ asset('images/user-profile-pic.png') }}" alt="user profile pic">
            </div>
            <div class="description">
                <div class="top">
                    <strong>John Foo</strong> | <a href="mailto:j-foo@gmail.com">j-foo@gmail.com</a> | <a href="#" class="tel">(646) 800-8090</a>
                </div>
                <div class="bottom">
                    Credit Blance: <strong>$300.00</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="site-offers">
        <div class="container">
            <p class="head">Share the coupon code or the link below to your friends and family. <br>With the link or code they will have discount on their purchase and you will gain credit. <br><strong>UNLIMITED REFERRALS</strong></p>

            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="img"><img src="{{ asset('images/5-credit.png') }}" alt="5 credit"></div>
                    <p class="border">$5 credit for every <br>customer recommended</p>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="img"><img src="{{ asset('images/100-credit.png') }}" alt="5 credit"></div>
                    <p class="border">Every 10 new <br>customers get $100 Credits</p>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="img"></div>
                    <p class="border">For every 25 purchases <br>get $150 Amazon Gift Card</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="referral-links">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <strong>Your Refer-A-Friend Link</strong>
                    <div class="links-block">
                        <input type="text" readonly value="http://flavorgod.com/?refer-a-friend=k021jd">
                        <ul class="buttons-list alternate">
                            <li><a href="#" class="btn btn-primary">copy link</a></li>
                            <li><a href="#" class="btn btn-default" data-toggle="modal" data-target="#shareModal">share link</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <strong>Your Refer-A-Friend Coupon Code</strong>
                    <div class="links-block">
                        <input type="text" readonly value="7DOE-15OFF">
                        <ul class="buttons-list alternate">
                            <li><a href="#" class="btn btn-primary">copy coupon</a></li>
                            <li><a href="#" class="btn btn-default" data-toggle="modal" data-target="#shareModal">share coupon</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="profile-how-it-works">
            <h3>how it works</h4>
            <div class="row">
                <div class="col-xs-12 col-lg-9 center-block">
                    <div class="row">
                        <div class="content-block col-xs-12 col-sm-4">
                            <div class="img">
                                <img src="{{ asset('images/how-it-works01.png') }}" alt="how it works 01">
                            </div>
                            <strong>STEP 1 </strong>
                            <p>Create Account or Login</p>
                        </div>
                        <div class="content-block col-xs-12 col-sm-4">
                            <div class="img">
                                <img src="{{ asset('images/how-it-works02.png') }}" alt="how it works 02">
                            </div>
                            <strong>STEP 2 </strong>
                            <p>Copy Link &amp; Coupon Code</p>
                        </div>
                        <div class="content-block col-xs-12 col-sm-4">
                            <div class="img">
                                <img src="{{ asset('images/how-it-works03.png') }}" alt="how it works 03">
                            </div>
                            <strong>STEP 1 </strong>
                            <p>Send to Friends &amp; Family</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="table-data-block">
            <header>
                <strong>MY CREDIT STATS</strong>
            </header>
            <table class="table">
                <thead>
                    <tr>
                        <th>Total Referrals Earned:</th>
                        <th>Total Bonuses Earned:</th>
                        <th>Total Gift Cards Earned:</th>
                        <th>CREDIT AVAILABLE:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Total Referrals Earned:">$100.00</td>
                        <td data-label="Total Bonuses Earned:">$200.00</td>
                        <td data-label="Total Gift Cards Earned:">-</td>
                        <td class="bold" data-label="CREDIT AVAILABLE:">$300.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="table-data-block">
            <header>
                <strong>MY REFERRAL STATS</strong>
            </header>
            <table class="table">
                <thead>
                    <tr>
                        <th>Total Referrals: <i data-toggle="tooltip" data-placement="right" data-title="Tooltip text here" class="fa fa-info-circle"></i></th>
                        <th>$100 Bonus:  <i data-toggle="tooltip" data-placement="right" data-title="Tooltip text here" class="fa fa-info-circle"></i></th>
                        <th>$150 Amazon Gift Card:  <i data-toggle="tooltip" data-placement="right" data-title="Tooltip text here" class="fa fa-info-circle"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Total Referrals:">20 x $5.00</td>
                        <td data-label="$100 Bonus:">$2 x $100.00</td>
                        <td data-label="$150 Amazon Gift Card:">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="table-data-block">
            <header>
                <strong>MY REFERRAL | <small>20</small></strong>
            </header>
            <table class="table">
                <colgroup>
                    <col style="width: 180px;">
                    <col style="width: 150px;">
                    <col>
                </colgroup>
                <thead>
                    <tr>
                        <th>Name:</th>
                        <th>Date:</th>
                        <th>Email:</th>
                    </tr>
                </thead>
            </table>
            <div class="vertical-scroll">
                <table class="table">
                    <colgroup>
                        <col style="width: 180px;">
                        <col style="width: 150px;">
                        <col>
                    </colgroup>

                    <tbody>
                        <tr>
                            <td data-label="Name:">Kyle Elliott</td>
                            <td data-label="Date:">11/13/2016</td>
                            <td data-label="Email:">kyle-elliot@hotmail.com</td>
                        </tr>
                        <tr>
                            <td data-label="Name:">Kyle Elliott</td>
                            <td data-label="Date:">11/13/2016</td>
                            <td data-label="Email:">kyle-elliot@hotmail.com</td>
                        </tr>
                        <tr>
                            <td data-label="Name:">Kyle Elliott</td>
                            <td data-label="Date:">11/13/2016</td>
                            <td data-label="Email:">kyle-elliot@hotmail.com</td>
                        </tr>
                        <tr>
                            <td data-label="Name:">Kyle Elliott</td>
                            <td data-label="Date:">11/13/2016</td>
                            <td data-label="Email:">kyle-elliot@hotmail.com</td>
                        </tr>
                        <tr>
                            <td data-label="Name:">Kyle Elliott</td>
                            <td data-label="Date:">11/13/2016</td>
                            <td data-label="Email:">kyle-elliot@hotmail.com</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="carousel-wrapper">
            <strong class="title">Here are some examples of how customers have shared their love of Flavorgod</strong>
            <div class="example-customers">
                @for ($i = 0; $i < 10; $i++)
                <div class="cust-block">
                    <div class="img">
                        <img src="{{ asset('images/example-customer.png') }}" alt="example customer">
                    </div>
                    <p>This is my first time trying #flavorgod seasoning on the frill and OH MY GISH! You can tell the quality of this product just by the smell!</p>
                </div>
                @endfor
            </div>
        </div>
    </div>
@stop

@section('modals')
    @include('raf.modals.modal1')
@stop

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
@stop

@section('lib-scripts')
    <script src="{{ asset('js/libs/jquery.mCustomScrollbar.min.js') }}"></script>
    <script src="{{ asset('js/libs/owl.carousel.min.js') }}"></script>
@stop

@section('scripts')
    <script>
        $('[data-toggle="tooltip"]').tooltip()

        $(".vertical-scroll").mCustomScrollbar({
            theme:"dark",
            axis:"y",
            autoHideScrollbar: true,
            scrollbarPosition: "inside"
        });

        $('.example-customers').owlCarousel({
            autoplay: true,
            items: 1,
            nav: true,
            dots: false,
            // pagination: true,
            loop: true,
            responsiveClass: true,
            smartSpeed: 1300,
            responsive: {
                320: {
                    items: 1
                },
                640: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 4
                }
            }
        });
    </script>
@stop
