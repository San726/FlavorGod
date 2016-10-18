@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

<?php $titleClass = "wholesale-title" ?>

@section('title', 'Wholesale')
@section('description', 'Flavorgod Wholesale Form - Become a Flavorgod reseller today!')
@section('keywords', 'flavorgod, wholesale, reseller, resale flavorgod')
@section('content')
    <div class="vip-list-section thankyou">        
        <div class="container">
            {{-- wholesale code here --}}
            <div class="white-bg">
                <div class="vip-section-inner">
                    <h3>Thank You</h3>
                    <p class="strong">Thanks for your interest in carrying my Flavor God brand and I look forward to working with you!! We will review your submission and be in touch within the next 1-3 days.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="vip-list-section section">
        <div class="container">
            {{-- vip list code here --}}
            <div class="top-media-box">
                <div class="vip-section-inner full-width">
                    <div class="media">
                        <div class="media-left media-middle">
                            <img src="https://s3.amazonaws.com/dash.flavorgod.com/assets/4386f07d95291d55603677c8304926d8b6d798ee.png" alt="wholesale page img">
                        </div>
                        <div class="media-body">
                            <h2>FLAVORGOD WHOLESALE</h2>
                            <p>When I first created Flavor God Seasonings in December of 2012, my goal was to <b>offer healthy seasonings</b> - unlike anything sold in stores - by using fresh herbs & spices. <i>My blends use real ingredients, minimal amounts of sea salt, and never have added chemicals or fillers.</i> I created Flavor God Seasonings with the principle of respecting ingredients, as they exist in nature while creating balanced flavors with all-purpose applications. My goal is to simply craft the best seasonings available on the market while making the art of cooking fun for anyone who uses my products.</p>
                            <p>After upgrading the size of my business operation yet again, I'm very excited to reveal that we are now open for <b>retail distribution</b> worldwide. We want to partner with the best privately owned walk-in stores, national franchises, and international distributors who want to carry my Flavor God brand alongside their own.</p>
                            <p><b>Thank you</b> for your interest in carrying Flavor God! <br/><i>I look forward to working with you.</i></p>
                            <p><img style="float:left;" src="{{ url('images/chriswallace-signature.png') }}" alt=""/></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sec-learn hidden-xs" style="height:300px;">
        <div class="dis-table">
            <div class="dis-table-cell">
                <div class="container">
                    <h3 style="font-size:32px"><strong>I am one man with a dream</strong> and support from the best team I could ever ask for in a company I built from the ground up to what it is today with loyal customers all over the world.</h3>
                </div>
            </div>
        </div>
        <div class="side-img side-right" style="position: relative; float: right; margin-top:-200px" >
            <img src="{{ url('images/img-learn-right.png') }}" alt=""/>
        </div>
    </div>
    <div class="wholesale-section wholesale-bottom">
        <div class="container">
            {{-- wholesale code here --}}
            <div class="top-media-box">
                <div class="wholesale-inner full-width">
                    <div class="media">
                        <div class="media-body">
                            <p>After upgrading the size of my business operation yet again, I'm very excited to reveal my newest project of retail distribution. As the owner of a small business, I'd like to give back to the same community of privately owned websites and walk-in stores who may carry my Flavor God brand alongside their own.
                            </p><p>
                            I wish you all the best of luck in your endeavors to build the best businesses possible as I welcome the opportunity to grow with you in the near future. Thank you for your interest in carrying my Flavor God brand and I look forward to working with you!!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
