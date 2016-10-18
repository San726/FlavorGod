@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

<?php $titleClass = "viplist-title" ?>

@section('title', 'Vip List')
@section('description', 'Find out how its possible to Paleo Seasoning, GMO Free, MSG Free and delicious flavoring all packed in one bottle!')
@section('keywords', 'paleo, msg free, seasoning, who is chris wallace, chris wallace, healthy seasonings')
@section('content')
    <div class="vip-list-section section">
        <div class="container">
            {{-- vip list code here --}}
            <div class="top-media-box">
                <div class="vip-section-inner rap-landing full-width">
                    <div class="media">
                        <div class="media-left media-middle">
                            <h4 class="visible-xs">FLAVORGOD REFERRAL PROGRAM</h4>
                            <img src="{{ asset('images/vip-page01.png') }}" alt="vip page img">
                        </div>
                        <div class="media-body">
                            <h4 class="hidden-xs">FLAVORGOD REFERRAL PROGRAM</h4>
                            <p class="strong">Invite your Friends &amp; Family</p>
                            <p>Refer your friends &amp; family, they recieve a discount and you recieve credits towards your next order!</p>
                            <p class="strong">Everyone Wins!</p>
                            <ul class="bullet-list">
                                <li>$5 Gift certificate for every customer recommended (No Minimum) </li>
                                <li>Every 10 new customers get $100 BONUS</li>
                                <li>For every 25 purchases get $150 Amazon Gift Card</li>
                            </ul>
                            <ul class="buttons-list">
                                <li><a href="#" class="btn btn-default">sign up</a></li>
                                <li><a href="#" class="btn btn-primary">log in</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="landing-block">
                <h4>how it works</h4>
                <ul class="landing-items">
                    <li>
                        <div class="landing-item">
                            <div class="media-img">
                                <img src="{{ asset('images/how-it-works01.png') }}" alt="how it works 01">
                            </div>
                            <div class="media-desc">
                                <h5>STEP1</h5>
                                <p class="strong">Create Account or Login</p>
                                <p>Get started now with a free account, you dont need to purchase to be able to take advantage of our Refer-A-Friend Program. Log In if you already have an account, otherwise Sign Up</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="landing-item">
                            <div class="media-img">
                                <img src="{{ asset('images/how-it-works02.png') }}" alt="how it works 02">
                            </div>
                            <div class="media-desc">
                                <h5>STEP2</h5>
                                <p class="strong">Copy Link &amp; Coupon Code</p>
                                <p>Once you Loged In your account, head over to the Refer-A-Friend program on your profile page and copy your Coupon Code and Link for your Friends and Family</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="landing-item">
                            <div class="media-img">
                                <img src="{{ asset('images/how-it-works03.png') }}" alt="how it works 03">
                            </div>
                            <div class="media-desc">
                                <h5>STEP3</h5>
                                <p class="strong">Send to Friends &amp; Family</p>
                                <p>Share the link and coupon code on social media, email, text message phone, or our favorite - in person!</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="thanks-block">
                    <div class="block-inner-hold">
                        <h4>we thank you</h4>
                        <p class="margin-bottom text-left">We appreciate you taking time out your day to share the experience you had with your friends and family. We rely on word-of-mouth to get new customers and we figured we would reward the fantastic customer base we have to grow it even more!</p>
                        <ul class="buttons-list">
                            <li><a href="#" class="btn btn-default">sign up</a></li>
                            <li><a href="#" class="btn btn-primary">log in</a></li>
                        </ul>
                    </div>
                    <div class="block-inner-hold faq">
                        <h4>FREQUENTLY ASKED QUESTIONS</h4>
                        <p class="big">How do I know if one of my friends or family members purchased?</p>
                        <ul class="bullet-list">
                            <li>You will recieve an e-mail when one of your friends or family members have purchased using your link or used your coupon to checkout!</li>
                        </ul>
                        <p class="big">How do I redeem my points to product</p>
                        <ul class="bullet-list">
                            <li>Your credit will pool in your account. When you are ready to redeem, sign in, browse the website and add products in your cart. At checkout you will be given an option to redeem your points</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
