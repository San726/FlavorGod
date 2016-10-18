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
                    <li><a href="#">Profile</a></li>
                    <li class="active"><a href="#">Edit Billing Address</a></li>
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

    <div class="container main-container-wrap">
        <div class="profile-editor">
            <header class="editor-header">
                <h4>edit billing address</h4>
            </header>
            <div class="editor-main">
                <div class="title-area">
                    <strong class="title">Billing Address</strong>
                </div>
                <ul class="profile-items">
                    <li>
                       <div class="item-title">
                           <strong>1 Main Street Apt. 3-P, New York…</strong>
                       </div>
                       <div class="item-links">
                           <span>
                               <a href="#">Edit</a> &nbsp; <a href="#">Delete</a>
                           </span>
                       </div>
                    </li>
                    <li>
                       <div class="item-title">
                           <strong>1 Main Street Apt. 3-P, New York…</strong>
                       </div>
                       <div class="item-links">
                           <span>
                               <a href="#">Edit</a> &nbsp; <a href="#">Delete</a>
                           </span>
                       </div>
                    </li>
                </ul>
            </div>
            <div class="editor-buttons">
                <a href="#" class="btn-left btn btn-profile"><i class="fa fa-angle-left"></i> PROFILE</a>
                <a href="#" class="btn btn-right btn-add">Add New Address</a>
            </div>
        </div>
    </div>
@stop
