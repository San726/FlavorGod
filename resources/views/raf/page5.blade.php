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
                    <li class="active"><a href="#">Edit Profile</a></li>
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
            <div class="editor-main no-height">
                <div class="title-area">
                    <a href="#" class="btn pull-right btn-add">Add New Address &nbsp;<i class="fa fa-plus-circle"></i></a>
                    <strong class="title">Billing Address</strong>
                </div>
                <form action="#" class="vip-form">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" placeholder="Street Address">
                    </div>
                    <div class="form-group">
                        <label>Apt. / Unit / Suite</label>
                        <input type="text" placeholder="Apt. / Unit / Suite">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" placeholder="Zip Code">
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="select-input">
                            <select>
                                <option>Choose State</option>
                                <option>State 1</option>
                                <option>State 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <div class="select-input">
                            <select>
                                <option>Choose Country</option>
                                <option>Nepal</option>
                                <option>USA</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="editor-buttons">
                <a href="#" class="btn-left btn btn-profile"><i class="fa fa-angle-left"></i> PROFILE</a>
                <a href="#" class="btn btn-right btn-save">SAVE</a>
            </div>
        </div>
    </div>
@stop
