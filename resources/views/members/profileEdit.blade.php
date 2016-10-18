@extends('app')

@section('content')
	 <header class="profile-header">
        <div class="profile-links">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">My Account</a></li>
                    <li><a href="/members/profile">Profile</a></li>
                    <li class="active"><a href="#">Edit Profile</a></li>
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
                <h4>edit user</h4>
                <div class="profile-pic-form">
                    <div class="file-block" id="updateImage">
                        <img src="{{ $currentUser->avatar }}" id="orig-profile-img" alt="{{ $currentUser->first_name .' '.$currentUser->last_name }}">
                    </div>
                </div>
            </header>
            <div class="editor-main no-height">
                <div class="title-area">
                    <strong class="title">Account Information</strong>
                </div>
                <div class="alert alert-danger error-list" role="alert" style="display: none"></div>
                <div class="alert alert-success success-message" role="alert" style="display: none"></div>
                <form action="#" class="vip-form">
                    <div class="form-group">
                        <input type="text" placeholder="First Name" value="{{ $currentUser->first_name }}" id="first_name_edit">
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Last Name" value="{{ $currentUser->last_name }}" id="last_name_edit">
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Email" value="{{ $currentUser->payer_email }}" id="email_edit" disabled="disabled">
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Contact Phone" value="{{ $currentUser->contact_phone }}" id="contact_phone_edit">
                    </div>
                </form>
            </div>
            <div class="editor-buttons">
                <a href="/members/profile" class="btn-left btn btn-profile"><i class="fa fa-angle-left"></i> PROFILE</a>
                <button class="btn btn-right btn-save">SAVE</button>
            </div>
        </div>
    </div>
@stop
@section('profileedit.script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.js"></script>
	<script>
        (function(){
            $('.btn-save').on('click', function(){
                var payload = {};
                payload.first_name = $('#first_name_edit').val();
                payload.last_name = $('#last_name_edit').val();
                payload.payer_email = $('#email_edit').val();
                payload.contact_phone = $('#contact_phone_edit').val();
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')} 
                });
                $.ajax({
                    type: 'PUT',
                    url: '/members/profile/edit',
                    data: payload
                })
                .done(function(data){
                    if(data.success){                  
                         $('.error-list').hide();
                        $('.success-message').html('<p><strong>Success!</strong> Profile updated.</p>').show(); 
                        $('#email_edit').val('{{ $currentUser->payer_email }}');//we are not allowing them to change/update their email address for now
                    }
                })
                .fail(function(error){
                    var error = JSON.parse(error.responseText);
                    if(error.errors.length){
                            var errorList = '<ul>';
                            $.each(error.errors, function(i, val){
                                errorList += '<li>' + val + '</li>';
                            });
                            errorList += '</ul>';
                            $('.success-message').hide();
                            $('.error-list').html(errorList).show();                        
                    }
                });        
                return;
            });           

            var myDropzone = new Dropzone('.profile-pic-form', {
                url: "/members/profile/edit/imageupload",
                paramName: 'profileimage',
                clickable: "#updateImage",
                thumbnailWidth: '275',
                thumbnailHeight: '275',
                acceptedFiles: '.jpg, .jpeg, .png, .bmp',
                addedfile: function(file){
                    //console.log(file);
                },
                thumbnail: function(file, dataUrl){
                     file.xhr.onload = function (e) {
                        if (this.status === 200) {
                            var response = JSON.parse(this.responseText);
                            $('#orig-profile-img').attr('src', response.image_path);
                        } else {
                            console.log('This file could not be uploaded');
                        }
                    }
                }             
            });
        })();
	</script>
@stop