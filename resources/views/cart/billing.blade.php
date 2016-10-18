@extends('cart.layout')
@section('content')
    <!--viplist section coding starts here-->
    <div class="viplist-section section">
        <div class="container">
            <!--vipform coding starts here-->
            <div class="row viplist-form col-xs-6">
                <div class="col-xs-12 pdlf0">
                    <h5>new <span>user</span></h5>
                    <div class="alert alert-danger billing-error-list" role="alert"></div>
                    <form id="new-user-form" action="/cart/billing" method="POST" novalidate>
			                <div class="form-group">
			                    <input type="text" name="billing_address" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="billing_address2" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="billing_country" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="billing_state" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="billing_city" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="billing_zip" class="form-control" value="" placeholder="">
			                </div>
			                <hr>
			                <h3>Shipping</h3>
			                <div class="form-group">
			                    <input type="text" name="shipping_address" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="shipping_address2" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="shipping_country" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="shipping_state" class="form-control" value="" placeholder="">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="shipping_city" class="form-control" value="" placeholder="Youremail@example.com">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="shipping_zip" class="form-control" value="" placeholder="Youremail@example.com">
			                </div>
			                <div class="form-group form-group-btn">
			                    <button type="submit" class="btn btn-default">submit</button>
			                </div>
			            </form>
			            <hr>
			            <a href="#" class="btn btn-default">Continue as a guest</a>
			           <hr>
			            <a href="#" class="btn btn-default">Sign Up With Google</a>
			            <a href="#" class="btn btn-default">Sign Up With Facebook</a>
			            <a href="#" class="btn btn-default">Sign Up With Instagram</a>
                </div>
            </div>
            <!--vipform coding ends here-->

        </div>
    </div>
    @section('scripts')
    <script>
        (function(){
                jQuery('.billing-error-list').hide();
                // jQuery('.auth-link').on('click', function(){
                //     jQuery('.error-list').hide();
                //     jQuery('.success-message').hide();
                // });
                // jQuery('.error-list').hide();
                // jQuery('.success-message').hide();
                // jQuery('#register-form').submit(handleFormSubmission);
                // jQuery('#login-form').submit(handleFormSubmission);
                jQuery('#billing-user-form').submit(handleContactFormSubmission);
                function handleContactFormSubmission(){
                    var form = jQuery(this);
                    var url = form.prop('action');
                    var method = form.find('input[name="_method"]').val() || 'POST';
                    var formData = form.serialize();
                    jQuery.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                         type: method,
                         url:  url,
                         data: formData
                    })
                    .done(function(data){

                        console.log(data);
                        // if(form.prop('id') === "password-retrieval"){
                        //     jQuery('.success-message').html('<p>'+data.success+'</p>');
                        //     jQuery('.error-list').hide();
                        //     jQuery('.success-message').show();
                        // }else{
                        //     if(data.success){
                        //         window.location.href = "/members/profile";
                        //     }
                        // }
                    })
                    .fail(function(error){
                        // console.log(error);
                        if(error.responseText){
                        var errorList = '<ul>';
                        var parsed = JSON.parse(error.responseText);
                        jQuery.each(parsed, function(i, val){
                            errorList += '<li>'+val.toString()+'</li>';
                        });
                        errorList += '</ul>';
                        jQuery('.billing-error-list').html(errorList);
                        jQuery('.blling-error-list').show();

                        }else{
                            console.log('Something went wrong please try again later.');
                        }
                    });
                    return false;
                }
        })();
    </script>
@stop
@stop