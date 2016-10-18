<div class="modal fade orders-modal" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="vipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="order-meta">
                    <div class="title">
                        <strong>order detail</strong>
                    </div>
                    <div class="address-meta">
                        <strong>Shipping Address:</strong>
                        John Foo <br>
                        1 Main Street, Apt. 3-P, New York, NY 110215
                    </div>
                    <div class="address-meta">
                        <strong>Billing Address:</strong>
                        John Foo <br>
                        1 Main Street, Apt. 3-P, New York, NY 110215
                    </div>
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
                                <th>Credit</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{ asset('images/flavor-god-bottles.png') }}" alt="flavor god bottles">
                                </td>
                                <td data-label="Item:" class="item">
                                    13 Pack Combo <br>
                                    Featuring Fiesta Sweet <br>
                                    and Tangy Seasoning
                                </td>
                                <td data-label="Price:">$99.00</td>
                                <td data-label="Quantity:">1</td>
                                <td data-label="Credit:">$0.00</td>
                                <td data-label="Total:">$99.00</td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ asset('images/flavor-god-bottles.png') }}" alt="flavor god bottles">
                                </td>
                                <td data-label="Item:" class="item">
                                    13 Pack Combo <br>
                                    Featuring Fiesta Sweet <br>
                                    and Tangy Seasoning
                                </td>
                                <td data-label="Price:">$99.00</td>
                                <td data-label="Quantity:">1</td>
                                <td data-label="Credit:">$0.00</td>
                                <td data-label="Total:">$99.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="amounts-meta">
                    <ul>
                        <li>
                            <span>Status:</span>
                            <strong>Shipped</strong>
                        </li>
                        <li>
                            <span>Subtotal:</span>
                            <strong>$198.00</strong>
                        </li>
                        <li>
                            <span>Shipping:</span>
                            <strong>$30.00</strong>
                        </li>
                        <li>
                            <span>Tax:</span>
                            <strong>$32.00</strong>
                        </li>
                        <li>
                            <span>Discount:</span>
                            <strong>$0.00</strong>
                        </li>
                        <li>
                            <span class="bold">Total Paid:</span>
                            <strong>$260.00</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
