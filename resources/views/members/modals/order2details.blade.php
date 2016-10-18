<div class="modal fade orders-modal" id="ordersModal2" tabindex="-1" role="dialog" aria-labelledby="vipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="order-meta">
                    <div class="title">
                        <strong>order detail</strong>
                    </div>
                    <div class="address-meta" id="address-meta-shipping"></div>
                    <div class="address-meta" id="address-meta-billing"></div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-data-block">
                    <table class="table alternate">
                        <colgroup>
                            <col style="width: 135px;">
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="order-item-details">                                                       
                        </tbody>
                    </table>
                </div>

                <div class="amounts-meta"></div>
            </div>
        </div>
    </div>
</div>
<script>
    (function(){
         $('#ordersModal2').on('hidden.bs.modal', function(){
            $('#order-item-details').html(''); 
            $('.amounts-meta').html('');
            $('#address-meta-shipping').html('');
            $('#address-meta-billing').html('');
         });



        $('.order-details').on('click', function(){
            var order_id = $(this).data('orderId');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')} });
            $.ajax({
                type: 'GET',
                url: '/members/orders/'+order_id,
                data: {
                    order_id: order_id
                }
            })
            .done(function(results){               
                var tableHtml = '';
                var order = results.order;
                var cart = results.cart;
                 for(var i = 0; i < results.order.items.length; i++){
                    for(asset in results.order.items[i]['product_variant']['assets']){
                        if(results.order.items[i]['product_variant']['assets'][asset]['relation_type'] === 'primary_image'){
                            var primary_image = results.order.items[i]['product_variant']['assets'][asset]['path'];
                            var total_for_item = results.order.items[i]['total'];
                            var price_per_each = results.order.items[i]['total']/results.order.items[i]['quantity'];
                            var qty_per_item = results.order.items[i]['quantity'];
                            var item_name = results.order.items[i]['name'];

                        }
                   }
                    tableHtml += '<tr><td><img src="'+primary_image+'" alt="'+item_name+'"></td>';
                    tableHtml += '<td data-label="Item:" class="item">'+item_name+'</td>';
                    tableHtml += '<td data-label="Price:">$'+price_per_each.toFixed(2)+'</td>';
                    tableHtml += '<td data-label="Quantity:">'+qty_per_item+'</td>';                    
                    tableHtml += '<td data-label="Total:">$'+total_for_item.toFixed(2)+'</td></tr>';
                 } 
                 $('#order-item-details').append(tableHtml); 
                 var totalAmounts = '<ul>';
                 var totalBottoms = ['Status', 'Subtotal', 'Discount', 'Credit', 'Shipping', 'Tax', 'Total paid'];
                 for(var i=0; i < totalBottoms.length; i++){
                    switch(totalBottoms[i]){
                        case 'Status':
                            totalAmounts += '<li><span>Status:</span><strong>'+order.order_status.name+'</strong></li>';
                        break;
                        case 'Subtotal':
                            var amount =  order.mc_gross + order.mc_discount + order.mc_store_credit;
                            amount = amount - order.mc_shipping - order.mc_handling - order.tax;
                            totalAmounts += '<li><span>Subtotal:</span><strong>$'+ amount.toFixed(2) +'</strong></li>';
                        break;
                        case 'Shipping':
                            var amount = order.mc_shipping + order.mc_handling;
                            totalAmounts += '<li><span>Shipping:</span><strong>$'+ amount.toFixed(2) +'</strong></li>';
                        break; 
                        case 'Tax':
                            totalAmounts += '<li><span>Tax:</span><strong>$'+ order.tax.toFixed(2) +'</strong></li>';
                        break;                            
                        case 'Discount':
                            totalAmounts += '<li><span>Discount:</span><strong>$'+ order.mc_discount.toFixed(2) +'</strong></li>';
                        break;
                        case 'Credit':
                            totalAmounts += '<li><span>Credit:</span><strong>$'+ order.mc_store_credit.toFixed(2) +'</strong></li>';
                        break;
                        case 'Total paid':
                            var amount = order.mc_gross;
                            totalAmounts += '<li><span class="bold">Total Paid:</span><strong>$'+ amount.toFixed(2) + '</strong></li>';
                        break;
                    }
                 }
                 totalAmounts += '</ul>';
                 var shippingAddress = '<strong>Shipping Address:</strong>';
                 var billingAddress = '<strong>Billing Address:</strong>';
                 shippingAddress += cart.shipping_firstname +' '+ cart.shipping_lastname + '<br>' + cart.shipping_address+' '+cart.shipping_address2+', '+cart.shipping_city+', '+cart.shipping_state+' '+cart.shipping_zip;
                 billingAddress += cart.billing_firstname +' '+ cart.billing_lastname + '<br>' + cart.billing_address+' '+cart.billing_address2+', '+cart.billing_city+', '+cart.billing_state+' '+cart.billing_zip;        
                 $('#address-meta-shipping').append(shippingAddress);
                 $('#address-meta-billing').append(billingAddress);
                 $('.amounts-meta').append(totalAmounts);
                 $('#ordersModal2').modal('show');
            })
            .fail(function(errors){
                console.log('The order could not be retrieved.');
            });
        });
    })();
</script>