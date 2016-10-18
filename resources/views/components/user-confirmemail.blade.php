 <!-- Email confirm Modal -->
        <div class="modal modal-vip fade" id="social-confirm-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="social-confirm-label" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="social-confirm-label">Please confirm your email</h4>

            <p>We need to know who you are. Enter email.</p>
                  </div>
            <div class="modal-body">
                <div class="alert alert-danger social-mail-error" role="alert"></div>
                    <form id="vip-modal-form" class="form-horizontal clearfix" role="form" action="/vip" method="POST" novalidate="" _lpchecked="1">
                    <div class="col-md-9 col-xs-12 no-gutter">
                        <div class="col-xs-12 no-gutter sm-gutter">
                            <input type="email" id="vip-email" name="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <button type="submit" class="btn btn-default btn-block" title="JOIN NOW">join now</button>
                        <div class="col-xs-12 block-cancel text-center">
                            <a href="/auth/logout" title="No thanks">No Thanks</a>
                        </div>
                    </div>
                </form>

            </div>

            </div>
          </div>
        </div>

        <!--Profile logging section coding ends here-->
        <!-- Middle section coding ends here-->
   @if(session('confirmModal'))
         <script>
            (function(){
                jQuery('.social-mail-error').hide();
                emailConfirmModal();
                function emailConfirmModal(){
                    jQuery('#social-confirm-modal').modal('show');
                }

                jQuery('#social-confirm-form').submit(socialConfirmFormSubmit);

                function socialConfirmFormSubmit(){
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
                        }).done(function(data){
                            if(data.success){
                                jQuery('#social-confirm-modal').modal('hide');
                                window.location.reload();
                            }
                            //console.log(data);
                            // jQuery('.vip-success-message').html('<p>'+data.success+'</p>');
                            // jQuery('.vip-error-list').hide();
                            // jQuery('.vip-success-message').show();
                            // form.find('#vip-email').val("");
                            // form.find('#vip-first-name').val("");
                            // form.find('#vip-last-name').val("");


                        })
                        .fail(function(error){

                             if(error.responseText){
                                    var errorList = '<ul>';
                                    var parsed = JSON.parse(error.responseText);
                                    jQuery.each(parsed, function(i, val){
                                        errorList += '<li>'+val.toString()+'</li>';
                                    });
                                    errorList += '</ul>';
                                    jQuery('.social-mail-error').html(errorList);
                                    jQuery('.social-mail-error').show();

                                }else{
                                    console.log('Something went wrong please try again later.');
                                }
                        });

                    return false;
                }

            })();
        </script>
    @endif