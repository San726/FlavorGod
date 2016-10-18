<!-- Vip List Modal -->
<div class="modal fade" id="vipModal" tabindex="-1" role="dialog" aria-labelledby="vipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-vip">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="vipModalLabel">GET EARLY ACCESS TO NEW FLAVORS!</h4>

                <img src="https://flavorgod.s3.amazonaws.com/homepage/vip-popup.jpg" />

                <p>Enter your email below to subscribe to the VIP list.</p>

                <ul class="benefits col-xs-12 clearfix">
                    <li><i class="fa fa-check-square-o"></i>Exclusive Discounts and Offers</li>
                    <li><i class="fa fa-check-square-o"></i>First Chance to Buy New Flavors</li>
                    <li><i class="fa fa-check-square-o"></i>Monthly Giveaways</li>
                </ul>

            </div>
            <div class="modal-body row">
                <!-- Begin MailChimp Signup Form -->
                <div class="alert alert-danger vip-error-list" role="alert"></div>
                <div class="alert alert-success vip-success-message" role="alert"></div>
                <form id="vip-modal-form" class="form-horizontal" role="form" action="/vip" method="POST" novalidate>
                    <div class="col-md-9 col-xs-12">

                        <div class="col-xs-12 no-gutter sm-gutter">
                            <input type="email" id="vip-email" name="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <button type="submit" class="btn btn-default btn-block" title="JOIN NOW">join now</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        function delayVipModal(){
            var domain = window.location.host;
            var domainParts = domain.split('.');
            var subDomain = domainParts[0];
            var noVipSubdomains = ['survey', 'ecamp'];         
            if(noVipSubdomains.indexOf(subDomain) == -1){
                window.setTimeout(showVipModal, 7000);
            }                       
        }

        function showVipModal() {
            jQuery('.vip-success-message').hide();
            jQuery('.vip-error-list').hide();
            jQuery('#vipModal').modal('show');
        }

        //Display Modal if cookie does not exists
        if (!jQuery.cookie('vipModal')) {
            delayVipModal();
            Date.prototype.addHours = function(h) {
                this.setHours(this.getHours() + h);
                return this;
            }
            var expirationTime = new Date().addHours(1);
            jQuery.cookie('vipModal', 'valid', {
                expires: expirationTime
            });
            //jQuery.cookie('vipModal', 1);
        }

        jQuery('.vip-success-message').hide();
        jQuery('.vip-error-list').hide();
        jQuery('#vip-modal-form').on('submit', vipModalFormSubmit);

        function vipModalFormSubmit(e) {
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
                    jQuery('.vip-success-message').html('<p>' + data.success + '</p>');
                    jQuery('.vip-error-list').hide();
                    jQuery('.vip-success-message').show();
                    form.find('#vip-email').val("");
                    form.find('#vip-first-name').val("");
                    form.find('#vip-last-name').val("");

                })
                .fail(function(error) {

                    if (error.responseText) {
                        jQuery('.vip-success-message').hide();
                        var errorList = '<ul>';
                        var parsed = JSON.parse(error.responseText);
                        jQuery.each(parsed, function(i, val) {
                            errorList += '<li>' + val.toString() + '</li>';
                        });
                        errorList += '</ul>';
                        jQuery('.vip-error-list').html(errorList);
                        jQuery('.vip-error-list').show();

                    }
                    else {
                        console.log('Something went wrong please try again later.');
                    }
                });

            if (e && e.preventDefault()) {
                e.preventDefault();
                e.returnValue = false;
            }

            return false;
        }

    })();
</script><!--