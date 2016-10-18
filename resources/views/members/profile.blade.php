@extends('app')

@section('content')

<header class="profile-header">
    <div class="profile-links">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">My Account</a></li>
                <li class="active"><a href="#">Profile</a></li>
            </ol>
            <a href="/auth/logout" class="logout">logout <i class="fa fa-sign-out"></i></a>
        </div>
    </div>
    <div class="tabs-box">
        <div class="container">
            <ul class="profile-tab">
                <li class="active"><a href="#">profile</a></li>
                <li><a href="/members/orders">my orders</a></li>
                <li><a href="/members/referralprogram">refer-a-friend</a></li>
            </ul>
        </div>
    </div>
</header>

<div class="container">
    <div class="profile-meta">
        <div class="pic big-in-tablet">
            @if($currentUser->auth_type == 'auth')
                <img src="{{ $currentUser->avatar }}" alt="{{ $currentUser->full_name }}">
            @elseif($currentUser->auth_type == 'oauth2')
                <img src="{{ $currentUser->oauth_avatar }}" alt="{{ $currentUser->full_name }}">
            @else
                <img src="{{ $currentUser->avatar }}" alt="{{ $currentUser->full_name }}"> 
            @endif
        </div>
        <div class="description">
            <div class="top">
                <strong>{{ $currentUser->full_name }}</strong> | <a href="mailto:{{ $currentUser->payer_email }}">{{ $currentUser->payer_email}}</a> | <a href="#" class="tel">{{ $currentUser->contact_phone }}</a>
                <div class="clearfix links-wrap">
                    <a href="/members/profile/edit" class="link pull-right">Edit Profile</a>
                    Member Since {{ $currentUser->member_since }}
                </div>
            </div>
            <div class="bottom">
                <div class="inline-block">
                    Credit Blance: <strong>${{ $currentUser->storeCreditAccount->balance }}</strong>
                </div>
                <a href="/members/referralprogram" class="link pull-right">View Statement</a>
            </div>
        </div>
    </div>
</div>

<div class="container main-container-wrap alternate-margin">
    @if($currentUser->addresses->count())
        <div class="row">
            <div class="col-xs-12 col-sm-6 table-block-padding">
                <div class="table-data-block">
                    <header>
                        <a href="/members/address/billing" class="btn pull-right btn-edit">edit</a>
                        <strong>BILLING ADDRESS</strong>
                    </header>
                    <div class="table-info">
                        @foreach($currentUser->addresses as $address)
                            @if($address->is_billing)
                                {{ $address->address_name }} <br>
                                {{ $address->address_street }} <br>
                                {{ $address->address_city }}, {{ $address->address_state }} {{ $address->address_zip }}, {{ $address->address_country_code }}
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 table-block-padding">
                <div class="table-data-block">
                    <header>
                        <a href="/members/address/shipping" class="btn pull-right btn-edit">edit</a>
                        <strong>SHIPPING ADDRESS</strong>
                    </header>
                    <div class="table-info">
                        @foreach($currentUser->addresses as $address)
                            @if($address->is_shipping)
                                {{ $address->address_name }} <br>
                                {{ $address->address_street }} <br>
                                {{ $address->address_city }}, {{ $address->address_state }} {{ $address->address_zip }}, {{ $address->address_country_code }}
                            @endif
                        @endforeach 
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-xs-12 col-sm-6 table-block-padding">
                <div class="table-data-block">
                    <header>
                        <a href="/members/address/create" class="btn pull-right btn-edit">add new</a>
                        <strong>SHIPPING ADDRESS</strong>
                    </header>
                    <div class="table-info"></div>
                </div>
            </div>
        </div>
    @endif
</div>
    @if($currentUser->orders->count())
        <div class="container main-container-wrap alternate-margin">
            <div class="table-data-block">
                <header>
                    <a href="/members/orders" class="btn pull-right btn-edit">view all</a>
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
                        @foreach($currentUser->orders as $order)
                            <tr>
                                <td data-label="name:">{{ $order->address_name }}</td>
                                <td data-label="order number:">{{ $order->external_order_id }}</td>
                                <td data-label="date:">{{ $order->date_of_purchase }}</td>
                                <td data-label="items:">{{ $order->items_count}}</td>
                                <td data-label="price:">${{ $order->mc_gross }}</td>
                                <td data-label="status:">
                                    <span class="label {{ $order->order_status_order_label }}">{{ $order->orderStatus->name }}</span>
                                </td>
                                <td>
                                    <ul class="order-links">
                                        <li><a href="#" data-order-id="{{$order->id}}" class="order-details">Details</a></li>
                                        <li><a href="#">Re-order</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop
@section('modals')
    @if($currentUser->orders->count())
        @include('members.modals.order2details')
    @endif
    @include('components.user-confirmemail')
@stop