
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
            <div class="white-bg">
                <div class="vip-section-inner">
                    <div class="img">
                        <img src="{{ asset('images/vip-face.png') }}" alt="vip face" width="162" height="162">
                    </div>
                    <h3>Thank You</h3>
                    <p class="strong">Thanks for your interest in becoming a flavor God Gourmet VIP!</p>
                    <p>We've received your request to become a flavor God Gourmet VIP! We value our customers' feedback. If you're chosen by our epicurean experts, you'll get free samples of Flavor God sent to you and, in return, you get to cook with it, eat and share your creations, and tell us all about it!</p>
                    <p>Please note we can't reply to everyone who applies so you will only hear from us if you're chosen. If you don't hear back, feel free to try again after 30 days.</p>
                    <p class="small">(No more than 1 form per 30 day period)</p>
                </div>
            </div>
        </div>
    </div>
@stop
