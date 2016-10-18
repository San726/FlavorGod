@extends('cart.layout')
@section('content')
    <!--viplist section coding starts here-->
    <div class="viplist-section section">
        <div class="container">
            <!--vipform coding starts here-->
            <div class="row viplist-form col-xs-6">
                <div class="col-xs-12 pdlf0">
                    <h5>Costumer information</h5>
                    <div class="alert alert-danger new-error-list" role="alert"></div>
                    <form id="new-user-form" action="/cart/contact" method="POST" novalidate>
			                <div class="form-group">
			                    <input type="email" name="contact_email" class="form-control" value="" placeholder="Youremail@example.com">
			                </div>
			                <div class="form-group form-group-btn">
			                    <button type="submit" class="btn">Continue to shipping method</button>
			                </div>
			            </form>
                </div>
            </div>
            <!--vipform coding ends here-->
        </div>
    </div>

    <!---->




    @section('scripts')
    <script>
        (function(){
                jQuery('.new-error-list').hide();
                jQuery('.existing-error-list').hide();
                // jQuery('.auth-link').on('click', function(){
                //     jQuery('.error-list').hide();
                //     jQuery('.success-message').hide();
                // });
                // jQuery('.error-list').hide();
                // jQuery('.success-message').hide();
                // jQuery('#register-form').submit(handleFormSubmission);
                // jQuery('#login-form').submit(handleFormSubmission);
                jQuery('#existing-user-form').submit(handleContactFormSubmission);
                jQuery('#new-user-form').submit(handleContactFormSubmission);
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
                                 if(form.prop('id') === "existing-user-form"){
                                        var errorList = '<ul>';
                                        var parsed = JSON.parse(error.responseText);
                                        jQuery.each(parsed, function(i, val){
                                            errorList += '<li>'+val.toString()+'</li>';
                                        });
                                        errorList += '</ul>';
                                        jQuery('.existing-error-list').html(errorList);
                                        jQuery('.existing-error-list').show();

                                    }else if(form.prop('id') === "new-user-form"){
                                        var errorList = '<ul>';
                                        var parsed = JSON.parse(error.responseText);
                                        jQuery.each(parsed, function(i, val){
                                            errorList += '<li>'+val.toString()+'</li>';
                                        });
                                        errorList += '</ul>';
                                        jQuery('.new-error-list').html(errorList);
                                        jQuery('.new-error-list').show();
                                    }
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