<!-- Feature links section coding starts here-->
<div class="col-xs-12 col-sm-5 pull-right footer-vip">
    <h3 class="">
        VIP LIST
        <small>Enter your email below to subscribe to the vip list.</small>
    </h3>
    <ul class="benefits col-xs-12 clearfix">
            <li><i class="fa fa-check-square-o"></i>Exclusive Discounts and Offers</li>
            <li><i class="fa fa-check-square-o"></i>First Chance to Buy New Flavors</li>
            <li><i class="fa fa-check-square-o"></i>Monthly Giveaways</li>
        </ul>
    <div class="alert alert-danger vip-footer-error-list" role="alert"></div>
            <div class="alert alert-success vip-footer-success-message" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
        <form id="vip-footer-form" class="form-horizontal" role="form" action="/vip" method="POST" novalidate>
            <div class="col-xs-8 no-gutter">
                <!--<label for="email" class="col-xs-2 control-label">Email</label>-->
                <!--<div class="col-xs-10">-->
                <!--    <input type="email" id="footer-vip-email" name="email" class="form-control" placeholder="Email">-->
                <!-- </div>-->
                <input type="email" id="footer-vip-email" name="email" class="form-control" placeholder="Email">
          </div>
            <div class="col-xs-4 no-gutter">
                    <button type="submit" class="btn btn-default btn-block" title="JOIN NOW">join now</button>
            </div>
        </form>
</div>
<script>
    (function(){
        jQuery('.vip-footer-success-message').hide();
        jQuery('.vip-footer-error-list').hide();
        jQuery('#vip-footer-form').submit(vipFooterFormSubmit);

         function vipFooterFormSubmit() {
            var form = jQuery(this);
            var url = form.prop('action');
            var method = form.find('input[name="_method"]').val() || 'POST';
            var formData = form.serialize();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                    type: method,
                    url: url,
                    data: formData
                }).done(function(data) {
                    //console.log('success');
                    jQuery('.vip-footer-success-message').html('<p>' + data.success + '</p>');
                    jQuery('.vip-footer-error-list').hide();
                    jQuery('.vip-footer-success-message').show();
                    form.find('#footer-vip-email').val("");

                })
                .fail(function(error) {

                    if (error.responseText) {
                        jQuery('.vip-footer-success-message').hide();
                        var errorList = '<ul>';
                        var parsed = JSON.parse(error.responseText);
                        jQuery.each(parsed, function(i, val) {
                            errorList += '<li>' + val.toString() + '</li>';
                        });
                        errorList += '</ul>';
                        jQuery('.vip-footer-error-list').html(errorList);
                        jQuery('.vip-footer-error-list').show();

                    }
                    else {
                        console.log('Something went wrong please try again later.');
                    }
                });

            return false;
        }

    })();
</script>