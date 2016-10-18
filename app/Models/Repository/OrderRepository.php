<?php

namespace Flavorgod\Models\Repository;

use Flavorgod\Models\Eloquent\Discount;
use Flavorgod\Models\Eloquent\DiscountCode;
use Flavorgod\Models\Eloquent\Order;
use Flavorgod\Models\Eloquent\OrderItem;
use Flavorgod\Models\Eloquent\CustomerAddress;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\Note;
use FitlifeGroup\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\Country;
use Flavorgod\Models\Eloquent\ProductVariant;
use Flavorgod\Services\WeHandlePayAPI;
use Flavorgod\Traits\MarshallsInputs;
use Flavorgod\Events\OrderCreatedEvent;
use Flavorgod\Events\OrderUpdatedEvent;
use Flavorgod\Services\ProductPricing;
use Flavorgod\Models\Eloquent\StoreCreditAccount;
use Flavorgod\Models\Eloquent\StoreCreditTransaction;
use Illuminate\Database\Eloquent\Collection;
use Flavorgod\Libraries\StoreCreditManager\Manager;
use Flavorgod\Libraries\ReferralProgram\ReferralProgram;
use Carbon\Carbon;
use Log;
use Auth;

class OrderRepository
{
    use MarshallsInputs;
    use DistinguishesAgent;
    use DistinguishesChannel;

    /*-- P R O T E C T E D   M E M B E R S -----------------------------------*/

    protected $products;
    protected $orders;
    protected $order;
    protected $custom;

    protected function throwIfNoOrder()
    {
        if (!isset($this->order)) {
            throw \Exception('No order selected');
        }
    }

    protected function normalizeOutput(Order $order)
    {
        $order->load('orderStatus', 'customer', 'items');
        $order['shipping'] = [
            'name' => $order['address_name'],
            'address_street' => $order['address_street'],
            'address_city' => $order['address_city'],
            'address_state' => $order['address_state'],
            'address_country_code' => $order['address_country_code'],
            'address_zip' => $order['address_zip'],
        ];
        $order['status'] = isset($order->orderStatus) ? $order->orderStatus->name : 'Unknown';

        return json_decode(json_encode($order), true);
    }

    protected function normalizeInput(array $order)
    {
        $order = $this->marshall($order, [
            'customer.first_name' => 'required|string',
            'customer.last_name' => 'required|string',
            'customer.email' => 'required|email',
            'customer.phone' => 'optional',
            'customer.instagram' => 'optional',
            'customer.address_name' => 'nie|optional:@shipping.address_name',
            'customer.address_street' => 'nie|optional:@shipping.address_street',
            'customer.address_street2' => 'nie|optional:@shipping.address_street2',
            'customer.address_city' => 'nie|optional:@shipping.address_city',
            'customer.address_state' => 'nie|optional:@shipping.address_state',
            'customer.address_zip' => 'nie|optional:@shipping.address_zip',
            'customer.address_country_code' => 'nie|optional:@shipping.address_country_code|optional:US|size:2|uppercase',
            'shipping.name' => 'required|string|rename:address_name',
            'shipping.address_street' => 'required|rename:address_street',
            'shipping.address_street2' => 'optional|rename:address_street2',
            'shipping.address_city' => 'required|rename:address_city',
            'shipping.address_state' => 'required|rename:address_state',
            'shipping.address_zip' => 'required|rename:address_zip',
            'shipping.address_country_code' => 'optional:US|size:2|rename:address_country_code|uppercase',
            'shipping.address_email' => 'optional|rename:address_email',
            'shipping.address_company' => 'optional|rename:address_company',
            'shipping.address_phone' => 'optional|rename:address_phone',
            'transaction_id' => 'required',
            'external_id' => 'required',
            'currency' => 'optional:USD',
            'tax' => 'optional:0|numeric:double',
            'discount_total' => 'optional:0|numeric:double',
            'shipping_fee' => 'optional:0|numeric:double',
            'handling_fee' => 'optional:0|numeric:double',
            'transaction_fee' => 'optional:0|numeric:double',
            'total' => 'required|numeric:double',
            'memo' => 'optional:',
            'items' => [
                'required',
                'min:1',
                'array' => [
                    'sku' => 'required|min:1',
                    'quantity' => 'required|numeric:double',
                    'price' => 'required:strict|numeric:double',
                    // 'sub_items' => [
                    //     'optional',
                    //     'array' => [
                    //         'sku' => 'required|min:1'
                    //     ]
                    // ]
                ]
            ]
        ]);

        if ($this->passes()) {
            // Create hash for countries and their country codes
            $countries = [];
            foreach (Country::all() as $country) {
                $countries[$country->code] = $country->name;
            }

            // Assign country values to order data
            $order['customer']['address_country'] = $countries[strtoupper($order['customer']['address_country_code'])];
            $order['address_country'] = $countries[strtoupper($order['address_country_code'])];

            // Minor transformation
            // concat addresses
            if (!empty($order['customer']['address_street2'])) {
                $order['customer']['address_street'] .= "\n".$order['customer']['address_street2'];
                unset($order['customer']['address_street2']);
            }
            if  (!empty($order['address_street2'])) {
                $order['address_street'] .= "\n".$order['address_street2'];
                unset($order['address_street2']);
            }

            // Normalize and validate items
            $skus = [];
            $items = [];
            foreach($order['items'] as $item) {
                $index = array_search($item['sku'], $skus);
                if ($index !== false) {
                    $items[$index]['quantity'] += $item['quantity'];
                    $items[$index]['total'] = $items[$index]['quantity'] * $items[$index]['price'];
                } elseif ($variant = ProductVariant::where('sku', $item['sku'])->first()) {
                    $skus[] = $item['sku'];
                    $items[] = [
                        'product_variant_id' => $variant->id,
                        'sku' => $variant->sku,
                        'name' => $variant->name,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['quantity'] * $item['price']
                    ];
                } else {
                    Log::error('Order input validation failed due to invalid product.');
                    $this->failWith('items', 'Order contains invalid product: `'.$item['sku'].'`.');
                }
            }

            //
            $order['items'] = $items;

            // Validate order totals
            // Order total should be the total of all items - discount_total + tax + shipping + handling
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['total'];
            }
            $total =  $subtotal - $order['discount_total'] + $order['tax'] + $order['shipping_fee'] + $order['handling_fee'];
            if (abs($order['total'] - $total) > 1)  {
                Log::error('Order input validation failed due to non-matching totals.', [
                    '$order' => $order,
                    'subtotal' => $subtotal,
                    'total' => $total
                ]);
                $this->failWith('total', 'Order total does not reflect total of items.');
            };
        }

        return $order;
    }

    protected function getOrderCustomer(array $custDetails)
    {
        // Retrieve customer or create a new one if non-existent
        try {
            $customer = Customer::where('payer_email', $custDetails['email'])->firstOrFail();
        } catch (\Exception $e) {
            $customer = new Customer;
        }
        $custDetails['address_street'] = trim(preg_replace('/\s+/', ' ', $custDetails['address_street'])); // remove new lines being created.
        $custDetails['avatar'] = '/images/cart-pro-img-2.jpg';
        $customer
        ->fill($custDetails)
        ->save();
        $referralCodeExists = $customer->referralDiscountCode()->first();
        $referralProgram = new ReferralProgram;////REFERRAL PROGRAM COUPON ACCOUNT, ADDRESS GENERATION//////
        $manager = new Manager;
        if(!$referralCodeExists){
            $referralProgram->setCustomer($customer)->createAndAssignReferralDiscountCode();           
        }
        $storeCreditAccountExists = $customer->storeCreditAccount()->first();
        if(!$storeCreditAccountExists){
            $manager->createAndAssignStoreCreditAccountTo($customer);
        }
        (new CustomerAddress)->createAndAssignTo($customer);
        return $customer;
    }


    protected function attachOrderItems(array $items)
    {
        foreach ($items as $item) {
            $orderItem = new OrderItem;
            $orderItem->fill($item);
            $orderItem->order()->associate($this->order);
            $orderItem->save();
        }
    }

    /*-- P U L I C   M E M B E R S -------------------------------------------*/

    const ORDER_STATUS_AWAITING_PAYMENT     = 1;
    const ORDER_STATUS_PROCESSING           = 2;
    const ORDER_STATUS_AWAITING_SHIPMENT    = 3;
    const ORDER_STATUS_SHIPPED              = 4;
    const ORDER_STATUS_DELIVERED            = 5;
    const ORDER_STATUS_CANCELLED            = 6;
    const ORDER_STATUS_ON_HOLD              = 7;

    public function index($take = 25, $skip = 0)
    {
        $this->throwIfNoChannel();
        $orders
            = $this->orders
            ->take($take)
            ->skip($skip)
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function ($order) {
                $order['item_count']
                    = (int) $order
                    ->items()
                    ->sum('quantity');
            });
        return $orders;
    }

    public function fetch($ofField, $byComparison = null, $withValue = null)
    {
        // Implementation of function overloading
        if (is_null($withValue) && is_null($byComparison)) {
            $withValue = $ofField;
            $ofField = 'uid';
            $byComparison = '=';
        } elseif (is_null($withValue) && isset($byComparison)) {
            $withValue = $byComparison;
            $byComparison = '=';
        }

        // Field Remapping
        switch (strtolower($ofField)) {
            case 'currency':
                $ofField = 'mc_currency';
            break;
            case 'shipping_fee':
                $ofField = 'mc_shipping';
            break;
            case 'handling_fee':
                $ofField = 'mc_handling';
            break;
            case 'transaction_fee':
                $ofField = 'mc_fee';
            break;
            case 'transaction_id':
                $ofField = 'txn_id';
            break;
            case 'total':
                $ofField = 'mc_gross';
            break;
            case 'external_id':
                $ofField = 'external_order_id';
            break;
        }


        $this->order
            = $this->orders
            ->with('customer', 'items')
            ->where($ofField, $byComparison, $withValue)
            ->first();

        if (isset($this->order)) {
            return $this->normalizeOutput($this->order);
        } else {
            return null;
        }

    }

    /**
     * Store an order
     * @param array $store
     * @param int $cartId
     *
     */
    public function store ($cart, array $order)
    {
        $order = $this->normalizeInput($order);

        // Make sure we are not making a duplicated order
        if (is_null($dup = Order::where('txn_id', @$order['transaction_id'])->first())) {
            Log::info('Creating a new order for tnx_id: '.@$order['transaction_id']);

            $customerData = array_pull($order, 'customer');
            $itemsData = array_pull($order, 'items');

            // overwrite billing with shipping details
            Log::info('Retrieving customer for order.');
            $customer = $this->getOrderCustomer(array_merge($customerData, $order));
            Log::info('Customer created or found.'.PHP_EOL.json_encode($customer->withHidden('id'), JSON_PRETTY_PRINT));

            // Create order even if validation fails
            // This is to ensure that all converted carts will always have
            // an associated order. If validation fails, put the order
            // automatically on hold.
            $this->order = new Order;
            Log::info('Filling order information.'.PHP_EOL.json_encode($order, JSON_PRETTY_PRINT));
            $order['address_street'] = trim(preg_replace('/\s+/', ' ', $order['address_street']));//remove new lines generated generated on this string
            $this->order->fill($order);
            Log::info('Saving new order.');
            $this->order->save();/////////CREATE ORDER/////////////

            Log::info('Attaching order items to order.'.PHP_EOL.json_encode(['order_id' => $this->order->id, 'items' => $itemsData], JSON_PRETTY_PRINT));
            $this->attachOrderItems($itemsData);///////ADD ORDER ITEMS////////////
            Log::info('Successfully attached order items.', ['order_id' => $this->order->id]);

            Log::info('Associating customer to order', [
                'customer_id' => $customer->id,
                'order_id' => $this->order->id
            ]);
            $this->order->customer()->associate($customer); ///ADD CUSTOMER TO ORDER/////////////
            if(!empty($cart['discounts'])){/////REFERRAL PROGRAM STORE CREDIT AND DISCOUNTS/////
               $this->recordReferralProgramTransaction($cart, $customer);
            }
            $this->order->save();
            Log::info('Setting order status.', ['order_id' => $this->order->id]);
            Log::info('Associating channel to order.', [
                'channel_id' => isset($this->channel) ? $this->channel->id : 0,
                'order_id' => $this->order->id
            ]);
            isset($this->channel) ? $this->order->channel()->associate($this->channel) : 0; ////ADD CHANNEL TO ORDER/////////
            Log::info('Associating agent to order.', [
                'agent_id' => isset($this->agent) ? $this->agent->id : 0,
                'order_id' => $this->order->id
            ]);
            isset($this->agent) ? $this->order->agent()->associate($this->agent) : 0; /////////ADD AGENT TO ORDER///////////
            $this->order->order_status_id = $this->passes() ? static::ORDER_STATUS_PROCESSING : static::ORDER_STATUS_ON_HOLD;
            Log::info('Setting payment date.', ['order_id' => $this->order->id]);
            $this->order->payment_date = \Carbon\Carbon::now()->subHour(3)->format('H:i:s M d, Y \P\S\T');
            Log::info('Setting custom.', ['order_id' => $this->order->id]);
            $this->order->custom = $this->custom;
            Log::info('Updating order.', ['order_id' => $this->order->id]);
            $this->order->save();
            Log::info('Order successfully updated.', ['order_id' => $this->order->id]);
            ////RECORDING STORE CREDIT / REFERRAL TRANSACTIONS////
            $manager = new Manager;
            if(Auth::check()){
                $user = Auth::user();
                $user->load('storeCreditAccount');
                $this->recordStoreCreditTransaction($manager, $user, $cart['id'], $this->order); 
                $this->setConvertedCartStoreCredit($manager, $cart['id'], $user->storeCreditAccount->id);
            }
            $this->setConvertedCartDiscountCode($manager, $cart['id']);          
            // Attach a note to the order for any failed validations
            // This is a good measure for CS or tech to find out what the
            // issue could be.
            if ($this->fails()) {
                Log::warning('Order Validation Failed', [
                    'order' => $order,
                    'errors' => $this->errors()
                ]);
                $message = 'Order Validation Failed'.PHP_EOL;

                foreach ($this->errors() as $field => $error) {
                    $message .= '['.$field.'] '.(is_array($error) ? implode(' ', $error) : $error).PHP_EOL;
                }

                $note = new Note;
                $note->notable_type         = 'Order';
                $note->notable_id           = $this->order->id;
                $note->notable_status_id    = $this->order->order_status_id;
                $note->note                 = $message;
                $note->save();
            }
        }
        else {
            Log::warning('Failed to save order. Duplicate transaction id found.'.PHP_EOL.json_encode($order, JSON_PRETTY_PRINT));
            $this->order = $dup;
        }
        return $this->normalizeOutput($this->order->fresh());
    }

    /**
     * array $cart
     */
    public function recordReferralProgramTransaction($cart, $customer)
    {
        $referralProgram = new ReferralProgram;
        if($referrer = $referralProgram->getReferrerCustomerFromCart($cart['id'])){
            if($isNewReferral = $referralProgram->setCustomertoValidateStoreCreditBonus($customer, $cart['id'], $referrer)){
                $referralProgram->processTransactionBonus($referrer)
                ->processStoreCreditBonus($referrer->id, $customer->id)
                ->processGiftCardBonus($referrer->id);                
            }
        }  
    }
    /**
     * array $cart
     */
    public function recordStoreCreditTransaction($manager, $loggedInUser, $cartId, Order $order)
    {       
        $storeCreditApplied = $manager->getStoreCreditAmountAppliedToCart($loggedInUser->storeCreditAccount->id, $cartId);
         Log::info('Retrieved store discount amount applied: $' . number_format($storeCreditApplied, 2) );
        if($storeCreditApplied > 0.00){                
            (new ReferralProgram)->processStoreCreditDeduction($loggedInUser->id, $storeCreditApplied);
            $cart = Cart::findOrFail($cartId);
            $cart->gross_store_credit = $storeCreditApplied;                    
            $cart->save();
            $order = $order->fresh();
            $order->mc_gross = $order->mc_gross - $storeCreditApplied; 
            $order->mc_store_credit = $storeCreditApplied;
            $order->save();
            Log::info('Store credit adjustment was processed: $' . number_format($storeCreditApplied, 2) . ' cart ID# ' .$cart['id']);                
        }        
    }
    
    public function setConvertedCartDiscountCode($manager, $cartId)
    {
        $manager->setCartDiscountCodeToConverted($cartId);
    }

    public function setConvertedCartStoreCredit($manager, $cartId, $storeCreditId)
    {
        $manager->setCartStoreCreditToConverted($storeCreditId, $cartId);
    }

    /**
     * Update an order
     *
     */
    public function patch(array $nothing)
    {
        $this->throwIfNoOrder();

        $order = $this->normalizeInput($order);

        if ($this->passes()) {
            // overwrite billing with shipping details
            $customer = $this->getOrderCustomer(array_merge($order['customer'], $order));

            // Update order
            $this->order->fill($order);
            $this->order->customer()->associate($customer);
            $this->order->save();

            $this->order->items()->destroy();
            $this->attachOrderItems($order['items']);

            return $this->normalizeOutput($this->order-fresh());
        }

        return null;
    }

    /**
     * Update an order
     * This is useful for fixing carts that had an issue converting, or maybe resetting an order to it's initial state
     */
    public function updateOrder(array $cart)
    {
        // $this->throwIfNoOrder();

        $cart = $this->normalizeInput($cart);

        // Make sure we are not making a duplicated order
        $this->order = Order::where('txn_id', @$cart['transaction_id'])->first();

        if ($this->order) {
            // overwrite billing with shipping details
            $customer = $this->getOrderCustomer($cart['customer'], $cart);

            // Update order
            $this->order->fill($cart);
            $this->order->customer()->associate($customer);
            $this->order->save();

            // $this->order->items()->destroy();
            $this->attachOrderItems($cart['items']);

            return $this->normalizeOutput($this->order->fresh());
        }

        return null;
    }

    /**
     * Soft delete an order
     *
     */
    public function erase()
    {
        $this->throwIfNoChannel();
        $this->throwIfNoOrder();
        return null;
    }

    /**
     * Get number of orders associated with channel
     *
     */
    public function count()
    {
        return $this->orders->count();
    }

    /**
     * Duplicate an order
     *
     */
    public function duplicate($override = [])
    {
        $this->throwIfNoOrder();
        // TODO: duplicate existing order
    }

    /**
     * Add order item
     *
     */
    public function addItem($sku, $qty = 1)
    {

    }

    /**
     * Update item quantity
     *
     */
    public function updateItem($sku, $qty = 1)
    {

    }

    /**
     * Remove
     *
     */
    public function removeItem($sku) {

    }

    public function setCustom($custom)
    {
        $this->custom = $custom;

        return $this;
    }

    public function getCustom()
    {
        return $this->custom;
    }

}
