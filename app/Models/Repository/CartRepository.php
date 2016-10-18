<?php

namespace Flavorgod\Models\Repository;

use DB;
use Flavorgod\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\CartItem;
use Flavorgod\Models\Eloquent\DiscountCode;
use Flavorgod\Models\Eloquent\ProductVariant;
use Flavorgod\Models\Eloquent\RecoveredCart;
use Flavorgod\Models\Repository\ProductRepository;
use Flavorgod\Services\ProductPricing;
use Carbon\Carbon;
use Exception;

class CartRepository
{
    use DistinguishesAgent;
    use DistinguishesChannel;

     const FREEGIFT1SKU = 'FG-T1';//Tier 1: $0-$50 Sku: JUL4-T1
     const FREEGIFT2SKU = 'FG-T2';//Tier 2: $51-$99 Sku: JUL4-T2
     const FREEGIFT3SKU = 'FG-T3';//Tier 3: $100+ Sku: JUL4-T3

    /**
     * The free gift skus for July 4th
     */
    protected $freeGiftsSkus = ['FG-T1', 'FG-T2', 'FG-T3'];

    protected $cart;
    protected $products;
    protected $custom;
    // Locators
    protected $sessionId;
    //
    protected $withClosedCarts = false;
    protected $lastResponse = NULL;
    protected $lastResponseType = NULL;

    /**
     * Throw exception if no cart is active
     *
     */
    protected function throwIfNoCart()
    {
        if (!isset($this->cart)) {
            throw new Exception('Cart not selected');
        }
    }

    protected function createIfNoCart()
    {
        if (!isset($this->cart)) {
            try {
                $this->fetchOrFail();
            } catch(Exception $e) {
                $this->cart = Cart::create(['sid' => $this->sessionId]);
            }
        }
    }

    public function resetTransaction($hard = false)
    {
        if (isset($this->cart)) {
            $this->cart->transaction_id = null;
            $this->cart->transaction_ref = null;
            $this->cart->save();
        }
    }

    public function convertToSale($orderId = null)
    {
        $this->cart->converted_at = Carbon::now();
        $this->cart->order_id = $orderId;
        $this->cart->custom = $this->custom;
        $this->cart->save();

        $this->cart->load('recoveredCarts');
        if($this->cart->recoveredCarts->count()){
            $this->cart->recoveredCarts->each(function($recovered){
                $recovered->converted = 1;
                $recovered->save();
            });
        }
    }

    protected function emptyCart()
    {
        return [
          "id" => null,
          "ip" => null,
          "custom" => null,
          "transaction_id" => "0",
          "transaction_ref" => null,
          "contact_email" => null,
          "contact_handle" => null,
          "contact_phone" => null,
          "contact_firstname" => null,
          "contact_lastname" => null,
          "billing_firstname" => null,
          "billing_lastname" => null,
          "billing_address" => null,
          "billing_address2" => null,
          "billing_city" => null,
          "billing_state" => null,
          "billing_zip" => null,
          "billing_country" => null,
          "shipping_firstname" => null,
          "shipping_lastname" => null,
          "shipping_address" => null,
          "shipping_address2" => null,
          "shipping_city" => null,
          "shipping_state" => null,
          "shipping_zip" => null,
          "shipping_country" => null,
          "currency" => "USD",
          "tax_rate" => "0",
          "shipping_fee" => null,
          "handling_fee" => 0,
          "token" => null,
          "order_id" => "0",
          "item_count" => 0,
          "sub_total" => 0,
          "shippable" => false,
          "discount_total" => 0,
          "tax" => 0,
          "total" => 0,
          "contact_name" => "",
          "billing_name" => "",
          "shipping_name" => "",
          "status" => 0,
          "discounts" => [],
          "items" => [],
        ];
    }

    protected function transformCart()
    {
        $cart = $this->cart->fresh();

        $cart->load('discounts.terms', 'items.product.assets', 'items.product.children', 'items.product.product', 'items.channel', 'items.agent');

        $cart['item_count'] = 0;
        $cart['sub_total'] = 0;
        $cart['shippable'] = false;
        $product_types = [];
        $cart
        ->items
        ->each(function($item) use ($cart, &$product_types) {
            if (isset($item->channel)) {
                if (isset($item->agent) && !$item->channel->override) {
                    $item['price'] = (double) ProductPricing::getPrice($item->product, $item->agent);
                }

                $item['price'] = (double) ProductPricing::getPrice($item->product, $item->channel);
            } else {
                $item['price'] = (double) ProductPricing::getMSRP($item->product);
            }
            $item['name'] = $item->product->name;
            $item['total'] = (double) ($item['quantity'] * $item['price']);
            $cart['item_count'] += $item['quantity'];
            $cart['sub_total'] += $item['total'];

            $cart['shippable'] = ($cart['shippable'] || $item->product->shippable);

            $assets = [];

            $item->product->assets->each(function ($asset) use (&$assets) {
                $assets[$asset->pivot->relation_type_name] = [
                    'name' => $asset->name,
                    'path' => $asset->path
                ];
            });

            $item['assets'] = $assets;
            $item['product_slug'] = $item->product->product->slug;

            $product_types[] = $item->product->product_type_id;

            $item->setVisible(['sku', 'name', 'quantity', 'price', 'total', 'assets', 'product_slug']);
        });
        $product_types = array_unique($product_types);
        $cart['product_types'] = $product_types;

        $cart['shipping_fee'] = $cart['shippable'] ? $cart['shipping_fee'] : null;

        $cart['discount_total'] = 0;
        $cart->discounts
        ->sortBy(function ($discount) {
            return $discount->terms->type;
        })
        ->each(function ($discount) use ($cart) {
            // Set a default discount value to apply
            $value = 0;

            // Determin if this discount is applicable
            $applicable = ($discount->terms->min_amount <= $cart->sub_total) &&
                          ($discount->terms->min_quantity <= $cart->items->count());
            // Calculate discount if applicable
            if ($applicable) {
                // What type of discount is this?
                // This is a rate discount
                if ($discount->terms->type) {
                    // Check rate discount limits and apply the discount rate only
                    if ($discount->terms->max_amount) {
                        $value = (double) $discount->terms->max_amount * ($discount->terms->value / 100);
                    } else {
                        $value = (double) $cart['sub_total'] * ($discount->terms->value / 100);
                    }
                    // $discount_rate += (1 - $discount_rate) * ($discount->terms->value / 100);
                }
                // This is a deduction discount
                else {
                    // We can't calculate limits for this form of discount
                    // Eventually we have to calculate limits for max quantity
                    // when we enable product specific discounts (maybe)
                    $value = (double) $discount->terms->value;
                    // $discount_amount += $discount->terms->value;
                }

                // Apply the discount to the subtotal and record add it to the
                // discount_total to keep track of the difference

                // $cart['sub_total'] -= $value;
                $cart['discount_total'] += $value;
            }

            // Add an attribute to the $discount to indicate how much was applied
            $discount['applied_value'] = $value;

            // Float Term elements to discount code
            $discount['value'] = (double) $discount->terms->value;
            $discount['type'] = $discount->terms->type ? 'percentage' : 'deduction';

            // Define which attributes to show
            $discount->terms->setVisible([
                'min_amount',
                'max_amount',
                'min_quantity',
                'max_quantity',
                'combinable'
            ]);

            // Define which attributes to show
            $discount->setVisible([
                'applied_value',
                'code',
                'value',
                'type',
                'terms',
                'deleted_at'
            ]);
        });

        $cart['tax'] = (double) ($cart['sub_total'] * $cart['tax_rate']);
        $cart['total'] = $cart['sub_total'] - $cart['discount_total'] + $cart['shipping_fee'] + $cart['handling_fee'] + $cart['tax'];

        $cart['contact_name'] = trim($cart['contact_firstname'].' '.$cart['contact_lastname']);
        $cart['billing_name'] = trim($cart['billing_firstname'].' '.$cart['billing_lastname']);
        $cart['shipping_name'] = trim($cart['shipping_firstname'].' '.$cart['shipping_lastname']);

        return json_decode(json_encode($cart), true);
    }

    /**
     * Add item to Cart
     *
     * @param string    $sku    Item sku number
     * @param int       $qty    Number of items to add
     *
     * @return Flavorgod\Models\Eloquent\CartItem     New cart item
     *
     */
    public function addItem($sku, $qty = 1)
    {
        $this->createIfNoCart();

        // Check if product is already in the cart
        try {
            $this->cart = $this->checkRecovered();

            $cartItem
            = $this->cart->items()
            ->doesntHave('children')
            ->where('sku', 'LIKE', $sku)
            ->firstOrFail();
            $cartItem->quantity += $qty;
        } catch (\Exception $e) {
            $cartItem = new CartItem;
            $cartItem->quantity = $qty;
        }

        $variant = ProductVariant::where('sku', 'like', $sku)->where('enabled', 1)->first();
        if (isset($variant)) {
            isset($this->channel) ? $cartItem->channel()->associate($this->channel) : 0;
            isset($this->agent) ? $cartItem->agent()->associate($this->agent) : 0;
            $cartItem->custom = $this->custom;
            $cartItem->product()->associate($variant);
            $item_unit_price = $this->getCartItemUnitPrice($cartItem);
            $cartItem->gross = round($item_unit_price*$qty,2);
            $this->cart->items()->save($cartItem);

            $this->resetTransaction();

        } elseif ($cartItem->exists()) {

            $cartItem->delete();
        }

        return $this;
    }

    /**
     * Update item in shopping cart
     *
     * @param string    $sku    Item sku number
     * @param int       [$qty = 1] Quantity to update cart item with
     *
     * @return Flavorgod\Models\Eloquent\CartItem     Updated cart item
     *
     */
    public function updateItem($sku, $qty = 1)
    {
        $this->createIfNoCart();

        // Check if product is already in the cart
        try {
            $this->cart = $this->checkRecovered();

            $cartItem = $this->cart->items()->where('sku', 'LIKE', $sku)->firstOrFail();
        } catch (\Exception $e) {
            $cartItem = new CartItem;
            $cartItem->sku = $sku;
        }

        $item_unit_price = $this->getCartItemUnitPrice($cartItem);
        $cartItem->gross = round($item_unit_price*$qty,2);

        if ($qty > 0) {
            // Validate Variant is available for us
            $variant = ProductVariant::where('sku', $sku)->where('enabled', 1)->first();
            if (isset($variant)) {
                // Update to current price and name
                $cartItem->quantity = $qty;
                $this->cart->items()->save($cartItem);

                $this->resetTransaction();

            }
        } elseif ($cartItem->exists()) {
            $cartItem->delete();
        }

        return $this;
    }

    /**
     * Remove item from shopping cart
     * @param int   $sku
     */
    public function removeItem($sku)
    {
        $this->cart = $this->checkRecovered();

        if ($this->cart && $cartItem = $this->cart->items()->where('sku', 'LIKE', $sku)->first()) {
            $cartItem->delete();
            $this->resetTransaction();
        }

        return $this;
    }

    /**
     * Display a listing of shopping carts
     * @param int $take
     * @param int $skip
     */
    public function index($take = 25, $skip = 0)
    {
        $carts = Cart::with('items')
            ->take($take)
            ->skip($skip)
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function ($cart) {
                    $cart['item_count'] = 0;
                    $cart['total'] = 0;
                        $cart
                        ->items()
                        ->each(function($item)use($cart){
                          $cart['item_count']++;
                          $cart['total']+=$item['quantity'] * $item['price'];
                        });
            });

        return $carts;
    }

    /**
     * Get current Cart data
     * @param string $odfield
     * @param string $byComparison
     * @param string $withValue
     */
    public function fetchOrFail(/* $args */)
    {
        $args = func_get_args();
        $fld = 'id';
        $opr = '=';
        $val = null;

        $query
        = Cart::with('items.channel', 'items.agent', 'items.product')
        // ->where('sid', 'like', !empty($this->sessionId) ? $this->sessionId : '%')
        ->orderBy('id', 'desc');

        if ( ! empty($this->sessionId)) {
          $query->where('sid', $this->sessionId);
        } elseif (empty($this->sessionId) && !count($args)) {
            throw new Exception('No Session ID');
        }

        if (!$this->withClosedCarts) {
            $query
            = $query
            ->where('order_id', 0)          // Not attributed to any order
            ->whereNull('converted_at')     // Not flagged as converted
            ->where('updated_at', '>', Carbon::now()->subHour()->format('Y-m-d H:i:s'));
        }

        if (count($args)) {
            switch (count($args)) {
                case 3:
                    $fld = array_shift($args);
                    $opr = array_shift($args);
                    $val = array_shift($args);
                    break;
                case 2:
                    $fld = array_shift($args);
                    $val = array_shift($args);
                    break;
                case 1:
                    $val = array_shift($args);
                    break;
            }

            $query = $query->where($fld, $opr, $val);
        }

        $this->cart = $query->firstOrFail();

        return $this->transformCart();
    }

    /**
     * Override method for fetching an item from the repository
     *
     * @param  mixed
     * @return array
     */
    public function fetch(/* args */)
    {
        try {
            $args = func_get_args();
            // Load current cart if no arguments passed
            if (empty($args) && isset($this->sessionId)) {
                //Determine whether this session is a recovering a cart that hasnt converted (recover)
                $recovered = RecoveredCart::where('new_sid', $this->sessionId)->orderBy('id','desc')->where('converted', NULL)->first();
                if($recovered){
                    $this->sessionId = $recovered->parent_sid;
                }
                $args = ['sid', $this->sessionId];
            }
            return call_user_func_array([$this, 'fetchOrFail'], $args);
        } catch (Exception $e) {
            return $this->emptyCart();
        }
    }

    /**
     * Perform check and adding free gifts to the cart
     * @param double $amount
     */
    public function qualifyForFreeGift($amount)
    {
      $this->refreshFreeGifts();
      if($amount <= 50.00 && $amount > 1.00){//Tier 1
        $this->addItem(static::FREEGIFT1SKU);
      }else if($amount >= 51.00 && $amount <= 99.00){//Tier 2
        $this->addItem(static::FREEGIFT2SKU);
      }else if($amount >= 99.00){//Tier 3
        $this->addItem(static::FREEGIFT3SKU);
      }
      return $this->fetch();
    }

    /**
     * Remove all free gifts from cart
     */
    public function refreshFreeGifts()
    {
      if($this->cart){
        $freeItems = $this->cart->items()->whereIn('sku', $this->freeGiftsSkus)->get();
        if($freeItems->count()){
          foreach ($freeItems as $item) {
            $this->removeItem($item->sku);
          }
        }
      }
    }

    public function patch(array $data)
    {
        $this->createIfNoCart();
        $result = $this->transformCart();
        $this->cart->gross = $result['total'];
        $this->cart->tax_rate = $result['tax_rate'];
        $this->cart->gross_discount = $result['discount_total'];
        $this->cart->gross_tax = $result['tax_rate']*$result['total'];
        $this->cart->fill($data);
        $this->cart->save();

        return $result;
    }

    public function store(array $fill = [])
    {
        $this->cart = Cart::create($fill);

        return $this->transformCart();
    }

    public function erase()
    {
        // Do Nothing
    }

    public function count()
    {
        return $this->carts->count();
    }

    /**
     * Find the appropiate failed message by processor code or failed message
     * @param string || int
     */
    public function getCartEventMessage($param)
    {
        $message =  \DB::table('cart_event_message')
            ->where('processor_code', $param)
            ->orWhere('incoming_message', $param)
            ->first();
        return $message;
    }

    /**
     * Get last response message
     * @return string
     */
    public function getLastResponseMessage()
    {
        return $this->lastResponse;
    }

    /**
     * Set last response message and type
     *
     * @param  string   $message
     * @param  string   $type
     * @return $this
     */
    public function setLastResponse($message, $type = '')
    {
        $this->lastResponse = $message;
        $this->lastResponseType = $type;
        return $this;
    }

    public function applyStoreCredit()
    {
        if(Auth::check()){
          $currentUser = Auth::user();
          dd('apply store credit CartRepository line 591');
        }
        return false;
    }

    /**
     * Apply discount code
     *
     * @param  string   $code
     * @return $this
     */
    public function applyDiscount($code)
    {
        $this->createIfNoCart();
        try {
            $this->cart = $this->checkRecovered();

            if (is_null($discount = $this->cart->discounts()->where('code', $code)->first())) {
                $discount
                = DiscountCode::enabled()
                ->whereHas('terms', function ($query) {
                    $query
                    ->where('enabled', 1);
                })
                ->with('terms', 'convertedCarts')
                ->where('code', $code)
                ->first();
                //make sure the coupon code does exists
                $couponCodeExists = DiscountCode::where('code', $code)->where('enabled', 1)->first();
                if(!$discount && $couponCodeExists){
                    $message =  $this->getCartEventMessage('Coupon expired');
                    $this->setLastResponse($message->auth_event_message, $message->type);
                    throw new Exception($message->auth_event_message, 1);
                }
                if(!$discount && !$couponCodeExists){
                    $message =  $this->getCartEventMessage('Coupon not found');
                    $this->setLastResponse($message->auth_event_message, $message->type);
                    throw new Exception($message->auth_event_message, 1);
                }
                if ($discount->terms->max_use > count($discount->convertedCarts)) {
                    //Find out if coupon has already been attached if so update If dont add for the first time
                    $results = DB::table('cart_discount_code')
                    ->where('cart_id', $this->cart->id)
                    ->where('discount_code_id', $discount->id)
                    ->first();
                    if(!is_null($results)){
                        DB::table('cart_discount_code')
                          ->where('cart_id', $this->cart->id)
                          ->where('discount_code_id', $discount->id)
                          ->update(['deleted_at' => NULL]);
                    }else{
                      $this->cart->discounts()->attach($discount); 
                    }
                                       
                    $message =  $this->getCartEventMessage('Valid Coupon');
                    $this->setLastResponse($message->auth_event_message, $message->type);
                } else{
                    $message =  $this->getCartEventMessage('Coupon not applicable');
                    $this->lastResponse = $message->auth_event_message;
                    throw new Exception($message->auth_event_message, 1);
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return $this;
    }

    /**
     * Remove all discounts attached to the cart
     *
     * @return $this
     */
    public function removeDiscounts()
    {

        $this->cart->discounts()->get()->each(function ($discount){
          \DB::table('cart_discount_code')
          ->where('id', $discount->cart_discount_code_id)
          ->limit(1)
          ->update(['deleted_at' => Carbon::now()]);
        });

        return $this;
    }

    /**
     * Remove a discount code from the cart
     *
     * @param  string   $code
     * @return $this
     */
    public function removeDiscount($code)
    {
        $this->createIfNoCart();
        $this->cart = $this->checkRecovered();

        if (isset($this->cart) && $discount = $this->cart->discounts()->where('code', $code)->first()) {
          \DB::table('cart_discount_code')
          ->where('id', $discount->cart_discount_code_id)
          ->limit(1)
          ->update(['deleted_at' => Carbon::now()]);
        }

        return $this;
    }

  /**
     * Store cart recovery information data
     * @param string
     * @param $recover bool || string
     * @return static
     */
    public function recoverCart($sid, $recover, $ref)
    {

        if($recover){
          $cart = Cart::where('sid', $sid)
                ->where('converted_at', NULL)
                ->orderBy('updated_at', 'desc')
                ->first();

          if($cart){
              $cart->load(['recoveredCarts' => function($query) use ($recover) {
                  $query->where('new_sid', $recover);
              }]);

              RecoveredCart::create([
                  'cart_id' => $cart->id,
                  'parent_sid' => $cart->sid,
                  'new_sid' => $recover
              ]);
              $recovered = RecoveredCart::where('new_sid', $recover)->first();

              $cart->touch();
              $recovered->updated_at = $cart->updated_at;
              $recovered->reference = $ref;
              $recovered->save();
          }
        }
        return $this;
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

    public function setSessionId($sessionId = null)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getSessionId()
    {
        return $this->sessionId;

    }

    public function withClosedCarts()
    {
        $this->withClosedCarts = true;

        return $this;
    }

    public function withoutClosedCarts()
    {
        $this->withClosedCarts = false;

        return $this;
    }

    public function takeOver($sessionId)
    {
        if (!empty($sessionId)) {
            $this->cart->sid = $sessionId;
            $this->cart->save();
            $this->setSessionId($sessionId);
        }
    }

    public function getCartItemUnitPrice($cartItem){

        if (!empty($cartItem->channel_id)) {
            if (isset($cartItem->agent) && !$cartItem->channel->override) {
                $item_price = (double) ProductPricing::getPrice($cartItem->product, $cartItem->agent);
            }

            $item_price = (double) ProductPricing::getPrice($cartItem->product, $cartItem->channel);
        } else {
            $item_price = (double) ProductPricing::getMSRP($cartItem->product);
        }
        return $item_price;
    }

    public function checkRecovered(){
        $recovered = RecoveredCart::where('new_sid', $this->sessionId)->orderBy('id','desc')->where('converted', NULL)->first();
        if($recovered){
            return Cart::where('sid', $recovered->parent_sid)->orderBy('id','desc')->first();
        }
        else return $this->cart;
    }

}
