@extends('app')
@section('content')
	 <header class="profile-header">
        <div class="profile-links">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">My Account</a></li>
                    <li class="active"><a href="#">My Orders</a></li>
                </ol>
                <a href="/auth/logout" class="logout">logout <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
        <div class="tabs-box">
            <div class="container">
                <ul class="profile-tab">
                    <li><a href="/members/profile">profile</a></li>
                    <li class="active"><a href="#">my orders</a></li>
                    <li><a href="/members/referralprogram">refer-a-friend</a></li>
                </ul>
            </div>
        </div>
    </header>
@if($firstOrder)
    <div class="container">
        <div class="profile-meta">
            <div class="pic big-in-tablet">                
                <img class="hidden-xs" src="{{ $firstAsset->path }}" alt="{{ $firstOrder->external_order_id }}">
            </div>
            <div class="description">
                <div class="top">
                    <strong>{{ $currentUser->payer_email }}</strong> | <a href="mailto:{{ $currentUser->payer_email }}">{{ $currentUser->payer_email }}</a> | <a href="#" class="tel">{{ $currentUser->contact_phone }}</a>
                    <br>
                    <a href="#" class="link order-details" data-order-id="{{$firstOrder->id}}">Order Details</a> &nbsp; &nbsp; <a href="#" class="link">Track Order</a>
                </div>
                <div class="bottom">
                    Total: <strong>${{ number_format($firstOrder->mc_gross, 2)}}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container-wrap">
        <div class="table-data-block">
            <header>
                <strong>MY ORDER HISTORY | <small>{{ $currentUser->orders->count() }}</small></strong>
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
                            <td data-label="price:">${{ number_format($order->mc_gross, 2) }}</td>
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
@else
    <div class="container">
        <div class="profile-meta">
            <div class="pic big-in-tablet">
                <img src="{{ $currentUser->avatar }}" alt="{{ $currentUser->full_name }}">
            </div>
            <div class="description">
                <div class="top">
                    <strong>{{ $currentUser->full_name }}</strong> | <a href="#">{{ $currentUser->payer_email}}</a> | <a href="#" class="tel">{{ $currentUser->contact_phone }}</a>
                    <div class="clearfix links-wrap">
                        <h4>You have (0) orders.</h4>
                    </div>
                </div>
                <div class="bottom">                   
                </div>
            </div>
        </div>
    </div>
@endif
@stop
@section('modals')
    @if($currentUser->orders->count())
        @include('members.modals.order2details')
    @endif
@stop