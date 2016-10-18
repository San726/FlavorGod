 <!-- Login Popup coding starts here-->
                <div class="modal fade modal-login" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-top">
                                    <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="modalLoginLabel">Sign In</h4>
                                    <div class="row">
                                        <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1">
                                            <div class="alert alert-danger error-list" role="alert" style="display: none"></div>
                                            <form id="login-form" action="/auth/login" method="POST" novalidate>
                                                <div class="form-group">
                                                    <input type="email" name="payer_email" class="form-control" placeholder="Example@gmail.com">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                                </div>
                                                <div class="form-group form-group-btn">
                                                    <button type="submit" class="btn btn-default">Sign In</button>
                                                </div>
                                                <div class="checkbox custom-radio">
                                                    <input id="remember" name="remember" type="checkbox">
                                                    <label for="remember">Remember Me</label>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-bottom">
                                    <ul class="social-login">
                                        <li>
                                            <a href="{{ url($mainUrl .'/google/authorize/' . $userIdentity) }}" class="gp" title="Sign-in with Gmail" target="_blank">
                                                <img src="https://flavorgod.s3.amazonaws.com/homepage/modal-google-icon.png" alt="Sign-in with Gmail" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url($mainUrl .'/facebook/authorize/' . $userIdentity) }}" class="fb" title="Sign-in with Facebook" target="_blank">
                                                <img src="https://flavorgod.s3.amazonaws.com/homepage/modal-fb-icon.png" alt="Sign-in with Facebook" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="modal-links">
                                    <a href="{{ url('#') }}" data-toggle="modal" data-target="#forget-pwd" title="forgot password?" class="auth-link">forgot password?</a>
                                    <a href="{{ url('#') }}" title="create an account" data-toggle="modal" data-target="#modalSignup" class="auth-link">create an account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Login Popup coding end here-->
                <!-- Forget Password Popup coding starts here-->
                <div class="modal fade modal-forgetpwd" id="forget-pwd" tabindex="-1" role="dialog" aria-labelledby="forgetpwdLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-top">
                                    <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="forgetpwdLabel">PASSWORD RETRIEVAL</h4>
                                    <p>Enter the email address below<br> and we’ll send you a link to reset your password.</p>
                                    <div class="row">
                                        <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1">
                                        <div class="alert alert-danger error-list" role="alert"></div>
                                        <div class="alert alert-success success-message" role="alert"></div>
                                            <form id="password-retrieval" action="/password/email" method="POST" novalidate>
                                                <div class="form-group">
                                                    <input type="email" name="payer_email" class="form-control" placeholder="Example@gmail.com">
                                                </div>

                                                <div class="form-group form-group-btn">
                                                    <button type="submit" class="btn btn-default">Send me the link</button>
                                                </div>
                                            </form>
                                            <p class="imp-txt">Important: If you registered for FLAVORGOD<br>by connecting via Facebook or Google, please<br>Sign In via that service before retrieving your password.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-bottom">
                                    <ul class="social-login">
                                        <li>
                                            <a href="{{ url($mainUrl . '/google/authorize') }}" class="gp" title="Sign-in with Gmail" target="_blank">
                                                <img src="https://flavorgod.s3.amazonaws.com/homepage/modal-google-icon.png" alt="Sign-in with Gmail" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url($mainUrl . '/facebook/authorize') }}" class="fb" title="Sign-in with Facebook" target="_blank">
                                                <img src="https://flavorgod.s3.amazonaws.com/homepage/modal-fb-icon.png" alt="Sign-in with Facebook" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <div class="modal-links">
                                <a href="{{ url('#') }}" title="create an account" data-toggle="modal" data-target="#modalSignup" class="auth-link">create an account</a>
                                <a href="{{ url('#') }}" title="SIGN IN" data-toggle="modal" data-target="#modalLogin" class="auth-link">SIGN IN</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Forget Password Popup coding end here-->
                <!-- Signup Popup coding start here-->
                <div class="modal fade modal-signup" id="modalSignup" tabindex="-1" role="dialog" aria-labelledby="modalSignupLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-top">
                                    <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="modalSignupLabel">Create An Account</h4>
                                    <div class="row">
                                        <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1">
                                            <div class="alert alert-danger error-list" role="alert"></div>
                                            <div class="alert alert-success success-message" role="alert"></div>
                                            <form id="register-form" action="/auth/register" method="POST" novalidate>
                                                <div class="form-group">
                                                    <input type="email" name="payer_email" class="form-control" placeholder="Example@gmail.com">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Retype Password">
                                                </div>
                                                <div class="form-group form-group-btn">
                                                    <button type="submit" class="btn btn-default">Register</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                 <div class="modal-bottom">
                                    <ul class="social-login">
                                        <li>
                                            <a href="{{ url($mainUrl .'/google/authorize/' . $userIdentity) }}" class="gp" title="Sign-in with Gmail" target="_blank">
                                                <img src="https://flavorgod.s3.amazonaws.com/homepage/modal-google-icon.png" alt="Sign-in with Gmail" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url($mainUrl .'/facebook/authorize/' . $userIdentity) }}" class="fb" title="Sign-in with Facebook" target="_blank">
                                                <img src="https://flavorgod.s3.amazonaws.com/homepage/modal-fb-icon.png" alt="Sign-in with Facebook" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        By clicking "Register", you certify that you are at<br>
                                        least 13 years old, and agree to our <a href="{{ url('/privacypolicy') }}" title="Privacy Policy">Privacy Policy</a> and<br>
                                        <a href="{{ url('/terms') }}" title="Terms of Service">Terms of Service</a>. Having trouble? <a href="{{ url('/contact') }}" title="Get help">Get help</a>.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Signup Popup coding end here-->
    <script>
        (function(){    

            $('.auth-link').on('click', function(){
                $('.error-list').hide();
                $('.success-message').hide();
                $( "input[name='payer_email']").val("");
                $( "input[name='password']").val("");
                $( "input[name='password_confirmation']").val("");                    
            });
            $('.error-list').hide();
            $('.success-message').hide();
            $('#register-form').submit(handleFormSubmission);
            $('#login-form').submit(handleFormSubmission);
            $('#password-retrieval').submit(handleFormSubmission);
            function handleFormSubmission(){
                var form = $(this);
                var url = form.prop('action');
                var method = form.find('input[name="_method"]').val() || 'POST';
                var formData = {
                    payer_email: form.find('input[name="payer_email"]').val(),
                    password: form.find('input[name="password"]').val(),
                    password_confirmation: form.find('input[name="password"]').val(),
                    cartId: "{{ isset($cart) ? $cart['id']: "" }}"
                };
                var email = $( "input[name='payer_email']" ).val() || "";
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                     type: method,
                     url:  url,
                     data: formData
                })
                .done(function(data){                        
                    if(data.success){
                        if(form.prop('id') === "login-form"){
                            window.location.href = "/members/profile";
                        }
                        $('.success-message').html('<p>'+data.success+'</p>');
                        $('.error-list').hide();
                        $('.success-message').show();
                        $( "input[name='payer_email']").val("");
                        $( "input[name='password']").val("");
                        $( "input[name='password_confirmation']").val(""); 
                    }else if(data.successWithCart){
                        window.location.href = "/cart/contact";
                    }                        
                })
                .fail(function(error){
                         if(error.responseText){
                            var parsed = JSON.parse(error.responseText);
                            if($.inArray('unverified', parsed.payer_email) > -1){
                                var errorList = '<p>You have not verified your email. Please check your inbox and follow the verification steps. Can\'t find the email? <a href="/email/sendverify/'+email+'">Click here to resend</a>.</p>';
                                $('.error-list').html(errorList);
                                $('.error-list').show();
                                return false;
                            }else if($.inArray('has_no_password', parsed.payer_email) > -1){
                                var errorList = '<p>Your account does not have a password registered. Please enter your password below.</p>';
                                $( "input[name='payer_email']").val(form.find('input[name="payer_email"]').val());
                                $( "input[name='password']").val('');
                                $( "input[name='password_confirmation']").val(''); 
                                $('.error-list').html(errorList);
                                $('.error-list').show();
                                $('#modalLogin').modal('hide');
                                $('#modalSignup').modal('show');
                                return false;
                            }                                
                            var errorList = '<ul>';
                            if(Object.keys(parsed).length > 1){
                                $.each(parsed, function(i, val){
                                    errorList += '<li>'+val[0]+'</li>';                                
                                });                                    
                            }else{
                                 $.each(parsed, function(i, val){
                                    if(Array.isArray(val)){
                                        errorList += '<li>'+val[0]+'</li>'; 
                                    }else{
                                        errorList += '<li>'+val+'</li>';                                           
                                    }
                                });
                            }
                                errorList += '</ul>';
                                $('.error-list').html(errorList);
                                $('.error-list').show();
                        }else{
                            console.log('Something went wrong please try again later.');
                        }
                });
                return false;
            }
        })();
    </script>