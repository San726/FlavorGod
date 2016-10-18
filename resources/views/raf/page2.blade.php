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
                    <li class="active"><a href="#">My Orders</a></li>
                </ol>
                <a href="#" class="logout">logout <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
        <div class="tabs-box">
            <div class="container">
                <ul class="profile-tab">
                    <li><a href="#">profile</a></li>
                    <li class="active"><a href="#">my orders</a></li>
                    <li><a href="#">refer-a-friend</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="profile-meta">
            <div class="pic big-in-tablet">
                <img class="visible-xs" src="{{ asset('images/user-profile-pic.png') }}" alt="user profile pic">
                <img class="hidden-xs" src="{{ asset('images/flavor-god-bottles.png') }}" alt="flavor-god-bottles">
            </div>
            <div class="description">
                <div class="top">
                    <strong>John Foo</strong> | <a href="mailto:j-foo@gmail.com">j-foo@gmail.com</a> | <a href="#" class="tel">(646) 800-8090</a>
                    <br>
                    <a href="#" class="link" data-toggle="modal" data-target="#ordersModal">Order Details</a> &nbsp; &nbsp; <a href="#" class="link">Track Order</a>
                </div>
                <div class="bottom">
                    Total: <strong>$99.00</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="table-data-block">
            <header>
                <strong>MY ORDER HISTORY | <small>3</small></strong>
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
                    <tr>
                        <td data-label="name:">John Foo</td>
                        <td data-label="order number:">6578902</td>
                        <td data-label="date:">8/26/2016</td>
                        <td data-label="items:">1</td>
                        <td data-label="price:">$99.00</td>
                        <td data-label="status:">
                            <span class="label cancelled">Cancelled</span>
                        </td>
                        <td>
                            <ul class="order-links">
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

@section('modals')
    @include('raf.modals.modal2')
@stop
