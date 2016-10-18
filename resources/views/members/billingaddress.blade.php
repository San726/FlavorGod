@extends('app')
@section('content')
	<header class="profile-header">
        <div class="profile-links">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Profile</a></li>
                    <li class="active"><a href="#">Edit Billing Address</a></li>
                </ol>
                <a href="/auth/logout" class="logout">logout <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
        <div class="tabs-box">
            <div class="container">
                <ul class="profile-tab">
                    <li class="active"><a href="/members/profile">profile</a></li>
                    <li><a href="/members/orders">my orders</a></li>
                    <li><a href="/members/referralprogram">refer-a-friend</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container main-container-wrap">
        <div class="profile-editor">
            <header class="editor-header">
                <h4>edit billing address</h4>
            </header>
                @if($currentUser->addresses->count())
		            <div class="editor-main">
		                <div class="title-area">
		                	<a href="/members/address/create" class="btn pull-right btn-add">Add New Address &nbsp;<i class="fa fa-plus-circle"></i></a>
		                    <strong class="title">Billing Address</strong>
		                </div>
		                <ul class="profile-items">
		                	@foreach($currentUser->addresses as $address)
			                    <li>
			                       <div class="item-title">
			                           <strong>{{ $address->address_street}}...</strong>
			                       </div>
			                       <div class="item-links">
			                       		@if($address->is_billing)
				                       		<span>
				                       			@if($currentUser->addresses->count() > 1)
				                               		<span class="label label-success">Default</span> &nbsp; <a href="/members/address/{{ $address->id }}/edit">Edit</a> &nbsp; <a href="/members/address/{{ $address->id }}/delete">Delete</a>
				                       			@else
				                               		<span class="label label-success">Default</span> &nbsp; <a href="/members/address/{{ $address->id }}/edit">Edit</a>
				                       			@endif
				                           </span>				                   
			                       		@else
			                       			<span>
			                       				@if($currentUser->addresses->count() > 1)
				                               		<a href="/members/address/{{ $address->id }}/billing/default">Make Default</a> &nbsp; <a href="/members/address/{{ $address->id }}/edit">Edit</a> &nbsp;  <a href="/members/address/{{ $address->id }}/delete">Delete</a> 
			                       				@else
					                               <a href="/members/address/{{ $address->id }}/billing/default">Make Default</a> &nbsp; <a href="/members/address/{{ $address->id }}/edit">Edit</a>
			                       				@endif
				                           </span>
			                       		@endif
			                       </div>
			                    </li>
		                	@endforeach		                  
		                </ul>
		            </div>
                @endif
            <div class="editor-buttons">
                <a href="/members/profile" class="btn-left btn btn-profile"><i class="fa fa-angle-left"></i> PROFILE</a>
                <a href="/members/address/create" class="btn btn-right btn-add">Add New Address</a>
            </div>
        </div>
    </div>
@stop