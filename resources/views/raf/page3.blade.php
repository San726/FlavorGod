@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

<?php $titleClass = "profile-title" ?>

@section('title', 'Vip List')
@section('description', 'Find out how its possible to Paleo Seasoning, GMO Free, MSG Free and delicious flavoring all packed in one bottle!')
@section('keywords', 'paleo, msg free, seasoning, who is chris wallace, chris wallace, healthy seasonings')
@section('content')
    <header class="profile-header">
        <div class="profile-links">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">My Account</a></li>
                    <li class="active"><a href="#">Profile</a></li>
                </ol>
                <a href="#" class="logout">logout <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
        <div class="tabs-box">
            <div class="container">
                <ul class="profile-tab">
                    <li class="active"><a href="#">profile</a></li>
                    <li><a href="#">my orders</a></li>
                    <li><a href="#">refer-a-friend</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="profile-meta">
            <div class="pic big-in-tablet">
                <img src="{{ asset('images/user-profile-pic.png') }}" alt="user profile pic">
            </div>
            <div class="description">
                <div class="top">
                    <strong>John Foo</strong> | <a href="mailto:j-foo@gmail.com">j-foo@gmail.com</a> | <a href="#" class="tel">(646) 800-8090</a>
                    <div class="clearfix links-wrap">
                        <a href="#" class="link pull-right">Edit Profile</a>
                        Member Since 2015
                    </div>
                </div>
                <div class="bottom">
                    <div class="inline-block">
                        Credit Blance: <strong>$300.00</strong>
                    </div>
                    <a href="#" class="link pull-right">View Statement</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap alternate-margin">
        <div class="row">
            <div class="col-xs-12 col-sm-6 table-block-padding">
                <div class="table-data-block">
                    <header>
                        <a href="#" class="btn pull-right btn-edit">edit</a>
                        <strong>BILLING ADDRESS</strong>
                    </header>
                    <div class="table-info">
                        John Foo <br>
                        1 Main Street, Apt. 3-P <br>
                        New York, NY 110215, US
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 table-block-padding">
                <div class="table-data-block">
                    <header>
                        <a href="#" class="btn pull-right btn-edit">edit</a>
                        <strong>shipping ADDRESS</strong>
                    </header>
                    <div class="table-info">
                        John Foo <br>
                        1 Main Street, Apt. 3-P <br>
                        New York, NY 110215, US
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap alternate-margin">
        <div class="table-data-block">
            <header>
                <a href="#" class="btn pull-right btn-edit">view all</a>
                <strong>RECENT ORDERS</strong>
            </header>
            <table class="table alternate">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>ORDER NUMBER</th>
                        <th>DATE</th>
                        <th>ITEMS</th>
                        <th>PRICE</th>
                        <th>STATUS</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="name:">John Foo</td>
                        <td data-label="order number:">6578902</td>
                        <td data-label="date:">8/26/2016</td>
                        <td data-label="items:">2</td>
                        <td data-label="price:">$99.00</td>
                        <td data-label="status:">
                            <span class="label pending">Pending</span>
                        </td>
                        <td>
                            <ul class="order-links">
                                <li><a href="#">Details</a></li>
                                <li><a href="#">Re-order</a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="name:">John Foo</td>
                        <td data-label="order number:">6578902</td>
                        <td data-label="date:">8/26/2016</td>
                        <td data-label="items:">1</td>
                        <td data-label="price:">$99.00</td>
                        <td data-label="status:">
                            <span class="label shipped">Shipped</span>
                        </td>
                        <td>
                            <ul class="order-links">
                                <li><a href="#">Track</a></li>
                                <li><a href="#">Details</a></li>
                                <li><a href="#">Re-order</a></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
