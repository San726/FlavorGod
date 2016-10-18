<?php

namespace Flavorgod\Http\Controllers;

use Illuminate\Http\Request;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\DiscountCode;
use Flavorgod\Models\Eloquent\Country;
use Flavorgod\Models\Eloquent\Zipcode;
use Flavorgod\Models\Eloquent\Channel;
use Flavorgod\Models\Eloquent\Agent;
use Flavorgod\Models\Eloquent\CartFailedAttempt;
use Flavorgod\Models\Repository\CartRepository;
use FitlifeGroup\Models\Eloquent\Cart;
use Flavorgod\Models\Repository\OrderRepository;
use Flavorgod\Traits\MarshallsInputs;
use Flavorgod\Services\WeHandlePayAPI;
use Flavorgod\Services\ChannelAttribution;
use Illuminate\Database\Eloquent\Collection;
use Flavorgod\Libraries\StoreCreditManager\Manager;
use Flavorgod\Libraries\StoreCreditManager\CreditManagerValidator;
use Carbon\Carbon;
use Exception;
use Log;
use Validator;
use Auth;
use Crypt;
use Illuminate\Support\MessageBag;
use Flavorgod\Libraries\DomainHelper as Domain;

class ShoppingCartController extends Controller
{

    use MarshallsInputs;

    protected $carts;
    protected $attrs;
    protected $orders;
    protected $domain;

    protected $keysToBeReplaced = [
        'number' => 'Card Number',
        'cvv' => 'CVV',
        'expiry_month' => 'Expiration Month',
        'expiry_year' => 'Expiration Year',
        'billing_firstname' => 'First Name',
        'contact_email' => 'Email',
        'shipping_firstname' => 'First Name',
        'shipping_lastname' => 'Last Name',
        'shipping_address' => 'Address',
        'shipping_addres2' => 'Address Line 2',
        'shipping_city' => 'City',
        'shipping_state' => 'State or Province',
        'shipping_zip' => 'Zip or Postal Code',
        'shipping_country' => 'Country',
        'billing_firstname' => 'First Name',
        'billing_lastname' => 'Last Name',
        'billing_address' => 'Address',
        'billing_addres2' => 'Addres Line 2',
        'billing_city' => 'City',
        'billing_country' => 'Country',
        'billing_state' => 'State or Province',
        'billing_zip' => 'Zip or Postal Code'
    ];

    protected $viewName;

    protected static $states = [
        // 50 States
        'AL'    => 'Alabama',
        'AK'    => 'Alaska',
        'AZ'    => 'Arizona',
        'AR'    => 'Arkansas',
        'CA'    => 'California',
        'CO'    => 'Colorado',
        'CT'    => 'Connecticut',
        'DE'    => 'Delaware',
        'FL'    => 'Florida',
        'GA'    => 'Georgia',
        'HI'    => 'Hawaii',
        'ID'    => 'Idaho',
        'IL'    => 'Illinois',
        'IN'    => 'Indiana',
        'IA'    => 'Iowa',
        'KS'    => 'Kansas',
        'KY'    => 'Kentucky',
        'LA'    => 'Louisiana',
        'ME'    => 'Maine',
        'MD'    => 'Maryland',
        'MA'    => 'Massachusetts',
        'MI'    => 'Michigan',
        'MN'    => 'Minnesota',
        'MS'    => 'Mississippi',
        'MO'    => 'Missouri',
        'MT'    => 'Montana',
        'NE'    => 'Nebraska',
        'NV'    => 'Nevada',
        'NH'    => 'New Hampshire',
        'NJ'    => 'New Jersey',
        'NM'    => 'New Mexico',
        'NY'    => 'New York',
        'NC'    => 'North Carolina',
        'ND'    => 'North Dakota',
        'OH'    => 'Ohio',
        'OK'    => 'Oklahoma',
        'OR'    => 'Oregon',
        'PA'    => 'Pennsylvania',
        'RI'    => 'Rhode Island',
        'SC'    => 'South Carolina',
        'SD'    => 'South Dakota',
        'TN'    => 'Tennessee',
        'TX'    => 'Texas',
        'UT'    => 'Utah',
        'VT'    => 'Vermont',
        'VA'    => 'Virginia',
        'WA'    => 'Washington',
        'WV'    => 'West Virginia',
        'WI'    => 'Wisconsin',
        'WY'    => 'Wyoming',
        // Territories
        'AS'    => 'American Samoa',
        'DC'    => 'District of Columbia',
        'FM'    => 'Federated States of Micronesia',
        'GU'    => 'Guam',
        'MH'    => 'Marshall Islands',
        'MP'    => 'Northern Mariana Islands',
        'PW'    => 'Palau',
        'PR'    => 'Puerto Rico',
        'VI'    => 'Virgin Islands',
        // Military Addresses
        'AA'    => 'Armed Forces Americas',
        'AE'    => 'Armed Forces',
        'AP'    => 'Armed Forces Pacific'
    ];

    protected static $provinces = [
        'AB'    => 'Alberta',
        'BC'    => 'British Columbia',
        'MB'    => 'Manitoba',
        'NB'    => 'New Brunswick',
        'NL'    => 'Newfoundland and Labrador',
        'NS'    => 'Nova Scotia',
        'NT'    => 'Northwest Territories',
        'NU'    => 'Nunavut',
        'ON'    => 'Ontario',
        'PE'    => 'Prince Edward Island',
        'QC'    => 'Quebec',
        'SK'    => 'Saskatchewan',
        'YT'    => 'Yukon',
    ];

    protected static function listCountries()
    {
        return Country::orderBy('name')->get(['code', 'name'])->toArray();
    }

    protected static function getCountry($code)
    {
        $country = Country::where('code', $code)->first();

        return $country ? $country->name : null;
    }

    protected static function getZipData($code)
    {
        $zipcode = Zipcode::where('code', $code)->first();

        return $zipcode ? $zipcode->toArray() : null;
    }

    protected static function isUSState($state)
    {
        $abbr = '/^((A[AEPLKSZR])|(C[AOT])|(D[EC])|(F[ML])|(G[AU])|(HI)|(I[DLNA])|(K[SY])|(LA)|(M[EHDAINSOT])|(N[EVHJMYCD])|(MP)|(O[HKR])|(P[WAR])|(RI)|(S[CD])|(T[NX])|(UT)|(V[TIA])|(W[AVIY]))$/i';
        $long = '/^((Armed\\sForces|Armed\\sForces\\s(Americas|Pacific))|Ala(bama|ska)|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Mi(chigan|nnesota|ssissippi|ssouri)|Montana|Nebraska|Nevada|New\\sHampshire|New\\s(Jersey|Mexico|York)|(North|South)\\sDakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode\\sIsland|(North|South)\\sCarolina|Tennessee|Texas|Utah|Vermont|(West\\s)?Virginia|Washington|Wisconsin|Wyoming|American\\sSamoa|District\\sof\\sColumbia|Federated\\sStates\\sof\\sMicronesia|Guam|(Marshall|Northern\\sMariana|Virgin)\\sIslands|Palau|Puerto\\sRico)$/i';

        $state = preg_replace('/\\s/', ' ', trim(strtoupper($state)));

        if (preg_match($abbr, $state)) {
            return $state;
        } elseif (preg_match($long, $state)) {
            return array_search($state, array_map('strtoupper', static::$states));
        } else {
            return false;
        }
    }

    protected static function isUSZipCode($zipcode)
    {
        $zipcode = trim($zipcode);
        if (preg_match('/^([0-9]{5})([\\s\\-\\+]([0-9]{4}))?$/', $zipcode, $m)) {
            return $m[1].(empty($m[3]) ? '' : '-'.$m[3]);
        } else {
            return false;
        }
    }

    protected static function isCAProvince($province)
    {
        $abbr = '/^(AB|BC|MB|N(B|L|S|T|U)|ON|PE|QC|SK|YT)$/i';
        $long = '/^(Alberta|British\\sColumbia|Manitoba|New\\sBrunswick|Newfoundland\\sand\\sLabrador|Nova\\sScotia|Northwest\\sTerritories|Nunavut|Ontario|Prince\\sEdward\\sIsland|Quebec|Saskatchewan|Yukon)$/i';

        $province = preg_replace('/\\s/', ' ', trim(strtoupper($province)));

        if (preg_match($abbr, $province)) {
            return $province;
        } elseif (preg_match($long, $province)) {
            return array_search($province, array_map('strtoupper', static::$provinces));
        } else {
            return false;
        }

    }

    protected static function isCAPostalCode($postal)
    {
        $postal = trim(strtoupper($postal));
        if (preg_match('/^([ABCEGHJKLMNPRSTVXY]\\d[ABCEGHJKLMNPRSTVWXYZ])\\s?(\d[ABCEGHJKLMNPRSTVWXYZ]\\d)$/', $postal, $m)) {
            return $m[1].' '.$m[2];
        } else {
            return false;
        }
    }

    public function normalizeCartId($id, $forLogging = false)
    {
        $str = 'FlavorGod Order #C'.str_pad($this->carts->getChannel()->id, 3, '0', STR_PAD_LEFT).'-'.str_pad($id, 8, '0', STR_PAD_LEFT);
        return $forLogging ? '[ ' . $str . ' ]' : $str;
    }

    protected function requestWhpDirectPayment(array &$cart, array &$card)
    {
        $whp = new WeHandlePayAPI;

        // Generate WHP payload data
        return $whp->makePayment([
            'external_id'   => $this->normalizeCartId($cart['id']),
            'amount'        => $cart['total'],
            'currency'      => $cart['currency'],
            'email'         => $cart['contact_email'],
            'name'          => $cart['billing_firstname'].' '.$cart['billing_lastname'],
            'card'          => $card,
            'billing'       => [
                'address1'      => $cart['billing_address'],
                'address2'      => $cart['billing_address2'],
                'city'          => $cart['billing_city'],
                'state'         => $cart['billing_state'],
                'postcode'      => $cart['billing_zip'],
                'country'       => $cart['billing_country'],
                'phone'         => $cart['contact_phone']
            ],
            'shipping'      => [
                'address1'      => $cart['shipping_address'],
                'address2'      => $cart['shipping_address2'],
                'city'          => $cart['shipping_city'],
                'state'         => $cart['shipping_state'],
                'postcode'      => $cart['shipping_zip'],
                'country'       => $cart['shipping_country'],
                'phone'         => $cart['contact_phone']
            ]
        ]);
    }

    protected function requestWhpPaymentStatus(array &$cart)
    {
        $whp = new WeHandlePayAPI;
        return $whp->showPayment($cart['transaction_id']);
    }

    protected function requestWhpPaymentAuthorization(array &$cart, $successUrl, $cancelUrl)
    {
        $whp = new WeHandlePayAPI;
        return $whp->requestAuthorization($this->normalizeCartId($cart['id']), $cart['total'], $successUrl, $cancelUrl);
    }

    protected function requestWhpPaymentCapture(array &$cart)
    {
        $whp = new WeHandlePayAPI;
        return $whp->executePayment($cart['transaction_id'], $cart['total'], $cart['currency']);
    }

    protected function transformCartToOrder(array $cart)
    {
        $items = [];
        foreach($cart['items'] as &$item) {
            $items[] = [
                'sku'       => $item['sku'],
                'quantity'  => $item['quantity'],
                'price'     => $item['price']
            ];
        }

        return [
            'external_id'       => $this->normalizeCartId($cart['id']),
            'transaction_id'    => $cart['transaction_ref'],
            'currency'          => $cart['currency'],
            'tax'               => $cart['tax'],
            'shipping_fee'      => $cart['shipping_fee'],
            'handling_fee'      => $cart['handling_fee'],
            'discount_total'    => $cart['discount_total'],
            'total'             => $cart['total'],
            'customer'          => [
                'first_name'        => $cart['contact_firstname'],
                'last_name'         => $cart['contact_lastname'],
                'email'             => $cart['contact_email'],
                'phone'             => $cart['contact_phone'],
                'instagram'         => $cart['contact_handle']
            ],
            'shipping'          => [
                'name'              => trim($cart['shipping_firstname'].' '.$cart['shipping_lastname']),
                'address_email'     => $cart['contact_email'],
                'address_phone'     => $cart['contact_phone'],
                'address_street'    => $cart['shipping_address'],
                'address_street2'   => $cart['shipping_address2'],
                'address_city'      => $cart['shipping_city'],
                'address_state'     => $cart['shipping_state'],
                'address_zip'       => $cart['shipping_zip'],
                'address_country_code' => $cart['shipping_country']
            ],
            'items'             => $items
        ];
    }

    protected function completeCartCheckout($transaction_id, $transaction_ref)////////////////////////VALID ORDER/////////////////////
    {
        // Update cart references
        $this->carts->patch([
            'transaction_id' => $transaction_id,
            'transaction_ref' => $transaction_ref
        ], false);

        // Get a new reference to cart and be absolutely sure it contains
        // a transaction_ref
        $cart = array_merge($this->carts->fetch(), [
            'transaction_ref' => $transaction_ref
        ]);
        $cartOrder = $this->transformCartToOrder($cart);
        // Store this order/
        try {
            Log::info($this->normalizeCartId($cart['id'], true) . ' - Creating an order from cart.');
            $order = $this->orders->store($cart, $cartOrder);/////////CREATING / STORING ORDER/////////////////
            Log::info($this->normalizeCartId($cart['id'], true) . ' - Successfully created order.');
        } catch (Exception $e) {
            // Log any failures to try to recover and rebuild
            Log::error($this->normalizeCartId($cart['id'], true) . ' - Failed to save order.'. PHP_EOL . json_encode([
                'cart' => $cart,
                'order' => $cartOrder
            ], JSON_PRETTY_PRINT));
            // Alert anyone that needs to be alerted
            Log::error('exception \'' . get_class($e) . '\' occurred while saving order with message \''. $e->getMessage() .'\''. PHP_EOL . 'Stack trace:' . PHP_EOL . $e->getTraceAsString());

            $order = $cartOrder;
        }

        $this->carts->convertToSale(@$order['id']);

        return $order;
    }

    protected function validateAddress(array &$data, $prefix = 'shipping_')
    {
        // Check for State Value
        if (in_array($data[$prefix.'country'], ['US','CA']) && empty($data[$prefix.'state'])) {
            $this->failWith($prefix.'state', 'required');
        }

        // Check for Zip Value
        if (in_array($data[$prefix.'country'], ['US', 'CA']) && empty($data[$prefix.'zip'])) {
            $this->failWith($prefix.'zip', 'reqired');
        }

        if ($this->passes()) {
            // Validate US States
            if ($data[$prefix.'country'] == 'US') {
                if ($state = static::isUSState($data[$prefix.'state'])) {
                    // Normalize State Name
                    $data[$prefix.'state'] = $state;
                } else {
                    $this->failWith($prefix.'state', 'Field must be a US state or territory.');
                }

                if ($zipcode = static::isUSZipCode($data[$prefix.'zip'])) {
                    // Normalize Zip Value
                    $data[$prefix.'zip'] = $zipcode;
                } else {
                    $this->failWith($prefix.'zip', 'Field must be a valid US zipcode format.');
                }
            }

            // Validate CA Provinces
            elseif ($data[$prefix.'country'] == 'CA') {
                if ($province = static::isCAProvince($data[$prefix.'state'])) {
                    // Normalize Province Name
                    $data[$prefix.'state'] = $province;
                } else {
                    $this->failWith($prefix.'state', 'Field must be a Canada province or territory.');
                }

                if ($postal = static::isCAPostalCode($data[$prefix.'zip'])) {
                    // Normalize Postal Code
                    $data[$prefix.'zip'] = $postal;
                } else {
                    $this->failWith($prefix.'zip', 'Field must be a Canada postal code.');
                }
            }
        }

        return $data;
    }

    protected function formatAddress(array &$data, $prefix = 'shipping_')
    {
        $address = [];

        $address[] = $data[$prefix.'firstname'].' '.$data[$prefix.'lastname'];
        $address[] = $data[$prefix.'address'];

        (empty($data[$prefix.'address2'])) ? 0 : $address[] = $data[$prefix.'address2'];

        if (in_array($data[$prefix.'country'], ['US', 'CA', 'NZ', 'AU'])) {
            $address[] = trim($data[$prefix.'city'].' '.@$data[$prefix.'state'].' '.$data[$prefix.'zip']);
        } else {
            $address[] = trim(@$data[$prefix.'zip'].' '.@$data[$prefix.'city'].' '.@$data[$prefix.'state']);
        }

        $address[] = strtoupper($this->getCountry($data[$prefix.'country']));

        return $address;
    }

    protected function computeAdditionalCharges(array &$data, $subtotal = null, $expedite = null)
    {
        if (isset($data['shipping_country']) && $data['shipping_country'] == 'US') {
            $subtotal = $subtotal ?: @$data['sub_total'];
            if (!is_null($subtotal)) {
                switch (true) {
                    case ($subtotal > 49):
                        $data['shipping_fee'] = 0.00;
                        break;
                    case ($subtotal > 10):
                        $data['shipping_fee'] = 6.00;
                        break;
                    default:
                        $data['shipping_fee'] = 4.00;
                        break;
                }
            }

            // Removed 05/24/2016
            // if ($data['shipping_state'] == 'NJ') {
            //     $data['tax_rate'] = 0.07;
            // } else {
            //     $data['tax_rate'] = 0;
            // }
        }
        elseif (isset($data['shipping_country']) && $data['shipping_country'] == 'CA') {
            //Shipping changed to US prices ON 2016-07-01
            //Shipping changed to $9 for Canada
            $subtotal = $subtotal ?: @$data['sub_total'];
            if (!is_null($subtotal)) {
                switch (true) {
                    case ($subtotal > 49):
                        $data['shipping_fee'] = 9.00;
                        break;
                    case ($subtotal > 10):
                        $data['shipping_fee'] = 4.00;
                        break;
                    default:
                        $data['shipping_fee'] = 0.00;
                        break;
                    }
                }

        }
        elseif (isset($data['shipping_country']) && $data['shipping_country'] == 'AU') {
            //Shipping for Australia set to $10.00 on 06/22/2016
            //Shipping for Australia set to $17.00 on 2016-07-21
            $data['shipping_fee'] = 17.00;
            $data['tax_rate'] = 0.0;
        }
        else {
            $data['shipping_fee'] = 17.00;
            $data['tax_rate'] = 0.0;
        }

        if (!is_null($expedite) && $expedite) {
            $data['handling_fee'] = 7.95;
        } else {
            $data['handling_fee'] = 0.00;
        }

        return $data;
    }

    protected function validateName(array &$data, $prefix = 'contact_')
    {
        list($first, $last) = $this->splitName($data[$prefix.'name']);

        if (empty($first) || empty($last)) {
            $this->failWith($prefix.'name', 'Name must contain a first and last name.');
        }

        $data[$prefix.'firstname'] = $first;
        $data[$prefix.'lastname'] = $last;

        return $data;
    }

    protected function validateContact(array $data)
    {
        $details = $this->marshall($data, [
            'contact_email'     => 'required|email',
            'contact_firstname' => 'optional',
            'contact_lastname'  => 'optional',
            'contact_phone'     => 'optional',
            'contact_handle'    => 'optional',
        ]);

        return $details;
    }

    protected function validateBilling(array $data)
    {
        $details = $this->marshall($data, [
            'billing_firstname' => 'required',
            'billing_lastname'  => 'required',
            'billing_address'   => 'required',
            'billing_address2'  => 'optional',
            'billing_city'      => 'required',
            'billing_state'     => 'required',
            'billing_zip'       => 'required',
            'billing_country'   => 'required|size:2',
            'billing_phone'     => 'optional'
        ]);

        if ($this->passes()) {
            $details = $this->validateAddress($details, 'billing_');
        }

        return $details;
    }

    protected function validateShipping(array $data)
    {
        $details = $this->marshall($data, [
            'shipping_firstname' => 'required',
            'shipping_lastname'  => 'required',
            'shipping_address'   => 'required',
            'shipping_address2'  => 'optional',
            'shipping_city'      => 'required',
            'shipping_state'     => 'required',
            'shipping_zip'       => 'required',
            'shipping_country'   => 'required:US|size:2'
        ]);

        if ($this->passes()) {
            $details = $this->validateAddress($details);
        }

        return $details;
    }

    protected function validateCreditCard(array $data)
    {
        $details = $this->marshall($data, [
            'number'            => 'required|card',
            'cvv'               => 'required|numeric:integer',
            'expiry_month'      => 'required|numeric:integer',
            'expiry_year'       => 'required|numeric:integer'
        ]);

        if ($this->passes()) {
            $expiry
            = Carbon::create($details['expiry_year'], $details['expiry_month'])
            ->modify('last day of this month')
            ->hour(23)
            ->minute(59)
            ->second(59);
            $today
            = Carbon::now()
            ->hour(0)
            ->minute(0)
            ->second(0);

            if ($expiry->lt($today)) {
                $this->failWith([
                    'expiry_month' => ['Expiration date must be a future date.'],
                    'expiry_year'  => ['Expiration date must be a future date.']
                ]);
            }
        }

        return $details;
    }

    protected function splitName($name)
    {
        // RegEx Pattern for finding common last name Affixes to break
        // break up name into the correct coponents
        $re = '/^(.*?)\\s(((A|Ab|Ap|Abu|Al|Ba(r|th)|Be(n|t)|Bint|Da|De|De(gli|le|l|lla|r)|Di|Dos|Du|E|El|Fitz|I|Kil|Gil|La|Le|M\'|Mac|Mc|Mhic|Mic|Mala|Na|Naka|Neder|Ni|Ni(c|n)|Nor(d|r)|Ny|O|Ua|Ui|Öfver|Ost|Över|Öz|Pour|Stor|Söder|Ter|Tre|Van|Väst|Vest|von)\\s)?([\\S\\-]*))$/i';
        if (preg_match($re, $name, $m)) {
            $first = $m[1];
            $last = $m[2];
        } else {
            $first = $name;
            $last = '';
        }

        return [$first, $last];
    }

    protected function validateWhp(array $data)
    {
        if (empty($data['name'])) {
            $firstname = $lastname = '';
        } else {
            list($firstname, $lastname) = $this->splitName($data['name']);
        }

        // Marshall information coming from WHP
        $details = $this->marshall($data, [
            'email'             => 'required|email|rename:contact_email',
            'contact_firstname' => [
                'transform' => [$firstname],
                'required'
            ],
            'contact_lastname'  => [
                'transform' => [$lastname],
                'required'
            ],
            'shipping_firstname' => [
                'transform' => [$firstname],
                'required'
            ],
            'shipping_lastname' => [
                'transform' => [$lastname],
                'required'
            ],
            'shipping.address1' => 'required|rename:shipping_address',
            'shipping.address2' => 'optional|rename:shipping_address2',
            'shipping.city' => 'required|rename:shipping_city',
            'shipping.state' => 'required|rename:shipping_state',
            'shipping.postcode' => 'required|rename:shipping_zip',
            'shipping.country' => 'optional:US|rename:shipping_country'
        ]);

        if ($this->passes()) {
            $details = $this->validateAddress($details);
        }

        return $details;
    }

    protected function shippingValidator(array $data)
    {
        return Validator::make($data, [
            'contact_email'      => 'required|email',
            'shipping_firstname' => 'required',
            'shipping_lastname'  => 'required',
            'shipping_address'   => 'required',
            'shipping_city'      => 'required',
            'shipping_state'     => 'required',
            'shipping_zip'       => 'required',
            'shipping_country'   => 'required'

        ]);
    }

    protected function ccValidator(array $data)
    {
        return Validator::make($data, [
            'number' => 'required|numeric',
            'cvv' => 'required|numeric',
            'expiry_month' => 'required|numeric',
            'expiry_year' => 'required|numeric'

        ], [
            'number.required' => 'The credit card number is required.',
            'number.numeric' => 'Please enter a valid credit card number.',
            'cvv.numeric' => 'Please enter a valid cvv.',
            'expiry_month.numeric' => 'The credit card expiration month must contain numbers only.',
            'expiry_year.numeric' => 'The credit card expiration year must contain numbers only.'
            ]);
    }

    protected function billingValidator(array $data)
    {
         return Validator::make($data, [
            'billing_firstname' => 'required',
            'billing_lastname' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_state' => 'required',
            'billing_zip' => 'required',
            'billing_country' => 'required'
        ]);

    }

    protected $freeGiftsSkus = ['FG-T1', 'FG-T2', 'FG-T3'];

   //Change error messages to human readable format
    protected function humanizeErrors(array $errors)
    {
       $newMessages = array();

        foreach($errors as $key => $value){
            $newKey = $this->filterErrorMessageKeys($key);
            if($newKey){
                $newMessages[$newKey] = $value;
            }
        }

        return $newMessages;
    }

    //Change error keys to human readable format
    protected function filterErrorMessageKeys($keyToTest)
    {
        return isset($this->keysToBeReplaced[$keyToTest]) ? $this->keysToBeReplaced[$keyToTest] : false;
    }

    public function __construct(CartRepository $carts, OrderRepository $orders, Request $request)
    {
        parent::__construct('cart');

        $this->carts = $carts;
        $this->orders = $orders;
        $this->attrs = new ChannelAttribution($request->server('HTTP_HOST'));
        $this->domain = new Domain;

        $recover = FALSE;
        $ref = '';

        if($request->has('sid')){
            $sid = $request->get('sid');
            if($request->has('recover')){
                if($request->get('recover') === 'true' || $request->get('recover') === 'TRUE'){
                    if($request->has('ref')){
                        $ref = $request->get('ref');
                    }
                    $recover = $request->session()->getId();
                }
          }
        }else{
            $sid = Auth::check() ? Auth::user()->payer_email : $request->session()->getId();
        }

        $this->carts
        ->setCustom($this->attrs->getCustom())
        ->setChannel($this->attrs->getChannel())
        ->setAgent($this->attrs->getAgent())
        ->recoverCart($sid, $recover, $ref)
        ->setSessionId($sid);

        $this->orders
        ->setCustom($this->attrs->getCustom())
        ->setChannel($this->attrs->getChannel())
        ->setAgent($this->attrs->getAgent());
    }

    /*--- R O U T E   H A N D L E R S ----------------------------------------*/

    public function index(Request $request)
    {
        $requestOrigin = $request->server('HTTP_HOST');//rt.flavorgod.com
        $freeGiftsSkus = $this->freeGiftsSkus;
        $cart = $this->carts->fetch();
        $session = $this->carts->getSessionId();
        $store = $this->attrs->getChannel();
        $currentQuery = $request->query();

        if ($request->has('_add')) {
            //////PRICE CHANGE/////
            $this->carts->addItem($request->input('_add'));
            unset($currentQuery['_add']);
            return redirect('cart?' . http_build_query($currentQuery));
        } elseif ($request->has('_remove')) {
            //////PRICE CHANGE/////
            $this->carts->removeItem($request->input('_remove'));
            unset($currentQuery['_remove']);
            return redirect('cart?' . http_build_query($currentQuery));
        }
        if ($request->has('coupon')) {
            $coupon = trim($request->input('coupon'));
            if ($this->carts->applyDiscount($coupon) == false) {
                alert()->error($this->carts->getLastResponseMessage());
            }elseif(!empty($this->carts->getLastResponseMessage())) {
                alert()->success($this->carts->getLastResponseMessage());
            }
            unset($currentQuery['coupon']);
            return redirect('cart?' . http_build_query($currentQuery))->with('message','Coupon was added.');
        } else {
            $cart = $this->carts->fetch();
            if($store->test_mode == 1){
                $cart = $this->carts->qualifyForFreeGift($cart['sub_total']);
            }
            $this->setViewName('cartIndex');
            $this->setTitleName('Shopping Cart');

            $eloquentCart = Cart::where('sid', $session)->first();
            $converted = NULL;
            if($eloquentCart && $eloquentCart->converted_at && $eloquentCart->transaction_ref){
                $converted = $eloquentCart;
            }

            return response()->view('cart.index', [
                'cart' => $cart,
                'freeGiftsSkus' => $freeGiftsSkus,
                'converted' => $converted
            ]);
        }
    }

    public function removeDiscountFromLink(Request $request, $code)
    {
        $this->carts->removeDiscount($code);
        return redirect('cart');
    }

    public function postIndex(Request $request)
    {
        $store = $this->attrs->getChannel();
        $requestOrigin = $request->server('HTTP_HOST');//rt.flavorgod.com
        if ($request->has('_update')) {
            switch ($request->input('_update')) {
                case 'quantity': // Q U A N T I T Y   U P D A T E
                    $items = $request->input('items', []);
                    foreach ($items as $item) {
                        //////PRICE CHANGE/////
                        $this->carts->updateItem($item['sku'], $item['quantity']);
                    }
                    // Fetch the cart at it's current state
                    $cart = $this->carts->fetch();
                    // Validate the shipping fields to see if shipping adjustments must
                    // be applied
                    $details = $this->validateShipping($cart);
                    // Compute any additional shipping charges if shipping is validated
                    if ($this->passes()) {
                        $details = $this->computeAdditionalCharges($details, $cart['sub_total']);
                        // Write the udpates to the cart
                        $this->carts->patch($details);
                    }
                    break;
                case 'zipcode': // Z I P C O D E   U P D A T E
                    // Get related zipcode information if avalailable
                    // and create a formatted shipping detail from it
                    if ($zipcode = $this->getZipData($request->input('zipcode'))) {
                        $details = [
                            'shipping_address'  => '',
                            'shipping_zip'      => $zipcode['code'],
                            'shipping_country'  => 'US',
                            'shipping_state'    => $zipcode['state'],
                            'shipping_city'     => $zipcode['city'],
                            'billing_address'   => '',
                            'billing_zip'       => $zipcode['code'],
                            'billing_country'   => 'US',
                            'billing_state'     => $zipcode['state'],
                            'billing_city'      => $zipcode['city']
                        ];
                    }
                    // Otherwise create a blnk shipping detail
                    else {
                        $details = [];
                    }
                    // Fetch the cart at it's current state
                    $cart = $this->carts->fetch();
                    // Compute any additional shipping charges
                    $details = $this->computeAdditionalCharges($details, $cart['sub_total']);
                    // Write the updates to the cart
                    $this->carts->patch($details);
                    break;
                case 'coupon': // C O U P O N   U P D A T E
                    // Get the coupon code from the input
                    $coupon = trim($request->input('coupon'));
                    // Apply the coupon code to the cart
                    if ($this->carts->applyDiscount($coupon) == false) {
                        alert()->error($this->carts->getLastResponseMessage());
                    }elseif(!empty($this->carts->getLastResponseMessage())) {
                        alert()->success($this->carts->getLastResponseMessage());
                    }

                    break;
            }
        } elseif ($request->has('_remove')) {
            //////PRICE CHANGE/////
            $this->carts->removeItem($request->input('_remove'));
        } elseif ($request->has('_add')) {
            if($request->ajax()){
                //////PRICE CHANGE/////
                $this->carts->addItem($request->input('_add'));
                $cart = $this->carts->fetch();
                if($store->test_mode == 1){
                    $cart = $this->carts->qualifyForFreeGift($cart['sub_total']);
                }
                return response()->json(['success' => 'Your item has been added.', 'itemsCount' => $cart['item_count']], 200);
            }
            //////PRICE CHANGE/////
            $this->carts->addItem($request->input('_add'));
        }
        if($store->test_mode == 1){
            $cart = $this->carts->fetch();
            $this->carts->qualifyForFreeGift($cart['sub_total']);
        }
        return redirect('cart');
    }

    public function getContact(Request $request)
    {
        $this->setViewName('CartContact');
        $this->setTitleName('shopping cart');

        $cart = $this->carts->fetch();

        // Make sure the cart has items
        if (count($cart['items']) === 0) {
            Log::warning($this->normalizeCartId($cart['id'], true) . ' - Contact page accessed with an empty cart.');
            return redirect('cart');
        }

        $countries = $this->listCountries();
        return response()->view('cart.contact', compact('cart', 'countries'));
    }

    /**
     * Record the store credit transaction for current user and cart
     */
    public function recordStoreCreditTransaction(Request $request, CreditManagerValidator $validator)
    {
        $params = $request->all();
        $validator = $validator->storeCreditTransaction($params);
        if($validator->fails()){
            return response()->json(['error' => array_flatten($validator->errors()->toArray())]);
        }
        $manager = new Manager;
        $user = Auth::user();
        $user->load('storeCreditAccount');
        $manager->recordStoreCreditTransactionToCart($params['cart_id'], $user->storeCreditAccount->id, $params['credit_amount']);
        if($request->ajax()){
            return response()->json(['success' => 'Store credit applied.']);
        }
    }
    /**
     * Remove store credit transaction for current user and cart
     */
    public function removeStoreCreditTransaction(Request $request, CreditManagerValidator $validator)
    {
        $params = $request->all();
        $validator = $validator->storeCreditTransaction($params);
         if($validator->fails()){
            return response()->json(['error' => array_flatten($validator->errors()->toArray())]);
        }
        $manager = new Manager;
        $user = Auth::user();
        $user->load('storeCreditAccount');
        if($removed = $manager->removeStoredCreditTransactionFromCart($params['cart_id'], $user->storeCreditAccount->id)){
            if($request->ajax()){
                return response()->json(['success' => 'Store credit removed.']);
            }
        }
    }


    public function postContact(Request $request)
    {
        // Get working cart model
        $cart = $this->carts->fetch();

        // Validate contact information from the input
        $contact = $this->validateContact($request->input());
        // Validate shipping information from the input
        $shipping = $this->validateShipping($request->input());
        // Copy shipping name to contact
        $contact['contact_firstname'] = @$shipping['shipping_firstname'];
        $contact['contact_lastname'] = @$shipping['shipping_lastname'];

        if ($this->passes()) {
            $shipping = $this->computeAdditionalCharges($shipping, $cart['sub_total'], $request->has('expedite'));
        }

        $details = array_merge($contact, $shipping);

        // Save any valid details regardless of direction of workflow
        $this->carts->patch($details, false);

        if ($request->has('_prev')) {
            return redirect('cart');
        } elseif ($this->passes()) {
            return redirect('cart/payment');
        } else {
            $errors = $this->errors();
            return back()->with([
                'errors' => $this->humanizeErrors($errors),
                'input' => $request->old()
            ]);
        }
    }

    public function getPayment(Request $request)
    {
        $this->setViewName('cartPayment');
        $this->setTitleName('shopping cart');

        $cart = $this->carts->fetch();

        // Make sure the cart has items
        if (count($cart['items']) === 0) {
            Log::warning($this->normalizeCartId($cart['id'], true) . ' - Payment page accessed with an empty cart.');
            return redirect('cart');
        }
        $this->validateContact($cart);
        $this->validateShipping($cart);
        // Check if validations failed and prevent users
        // from landing on this page
        if ($this->fails()) {
            return redirect('cart/contact');
        }
        $storeCreditAmount = 0.00;
        $storeCreditManager = new Manager;
        $creditApplied = 0.00;
        if(Auth::check()){
            $user = Auth::user();
            $user->load('storeCreditAccount');
            $storeCreditAmount = $storeCreditManager->getStoreCreditAvailableForCart(Auth::user(), $cart['total']);
            $creditApplied = $storeCreditManager->getStoreCreditAmountAppliedToCart($user->storeCreditAccount->id, $cart['id']);
        }
         $countries = $this->listCountries();
         $todaysYear = Carbon::now()->format('Y');
         $todaysMonth = Carbon::now()->format('m');
        if(!empty($cart['discounts']) && !empty($cart['contact_email'])){
            $coupons = new Collection($cart['discounts']);
            if($codebelongs = $this->checkCouponBelongsToCurrentCustomer($coupons->lists('code'), $cart['contact_email'])){
                $this->carts->removeDiscount($codebelongs);
                $cart = $this->carts->fetch();
                $errors = [];
                $errors['Coupon code error'] = ['The coupon code '.$codebelongs.' cannot be applied. Please read coupon rules.'];
                return response()->view('cart.payment', compact('cart', 'countries', 'todaysYear', 'todaysMonth', 'errors', 'storeCreditAmount', 'creditApplied'));
            }
        }
       return response()->view('cart.payment', compact('cart', 'countries', 'todaysYear', 'todaysMonth', 'storeCreditAmount', 'creditApplied'));
    }

    /**
     * Find aout if coupon's applied belong to same person making the purchase
     * if so we cannot apply this coupon to the cart
     *
     * @param array $couponCodes
     * @param string $contactEmail
     *
     * @return bool || string
     */
    private function checkCouponBelongsToCurrentCustomer($couponCodes, $contactEmail)
    {
        $coupons = DiscountCode::whereIn('code', $couponCodes)->get();
        $customer = Customer::where('payer_email', $contactEmail)->first();
        if($customer){
            $couponWithReferrer = $coupons->filter(function($coupon) use ($customer) {
                return $coupon->referrer_customer_id == $customer->id;
            });
            if($couponWithReferrer->count()){
                $coupon = $couponWithReferrer->first();
                return $coupon->code;
            }
        }
        return false;
    }

    /**
     * @param array $cart
     * @return array $cart
     */
    public function checkForStoreCreditsAppliedBeforePayment(array $cart)
    {
        if(Auth::check()){
            $storeCreditManager = new Manager;
            $user = Auth::user();
            $user->load('storeCreditAccount', 'referralDiscountCode');
            $creditApplied = $storeCreditManager->getStoreCreditAmountAppliedToCart($user->storeCreditAccount->id, $cart['id']);
            if($creditApplied > 0.00){
                $cart['total'] = $cart['total'] - $creditApplied;
                $cart['gross'] = $cart['gross'] - $creditApplied;
                Log::info('Cart total updated, Store discount. cart ID: '.$cart['id']. ' total after discount : $' . number_format($cart['total'], 2) . ' credit applied: $'.number_format($creditApplied, 2));
            }
        }
        return $cart;
    }

    public function postPayment (Request $request)
    {
        // Reset any pending transactions prior to payment
        $this->carts->resetTransaction();
        $cart = $this->carts->fetch();
        // Make sure the cart has items
        if (count($cart['items']) === 0) {
            Log::error($this->normalizeCartId($cart['id'], true) . ' - Payment attempted on an empty cart.');
            return redirect('cart/error');
        }

        // All payments posted here should be credit card payments
        // with cart status set to 0 (open)
        if ($cart['status'] == 0) {
            $this->validateContact($cart);      // Redundant but safe
            $this->validateShipping($cart);     // Redundant but safe
            // Capture billing information from input
            $billing = $this->validateBilling($request->input());
            // Capture card information from input
            $card = $this->validateCreditCard($request->input());
            // Do all validations pass?
            if ($this->passes()) {
                // save billing information
                $cart = $this->carts->patch($billing);
                $cart = $this->checkForStoreCreditsAppliedBeforePayment($this->carts->fetch());
                // Send direct payment request to WHP
                Log::info($this->normalizeCartId($cart['id'], true) . ' - Capturing direct payment.' . PHP_EOL . json_encode($cart, JSON_PRETTY_PRINT));
                /////////////////////////POST PAYMENT////////////////////
                $response = $this->requestWhpDirectPayment($cart, $card);
                Log::info($this->normalizeCartId($cart['id'], true) . ' - Capture Response:' . PHP_EOL . json_encode($response, JSON_PRETTY_PRINT));
                $manager = new Manager;
                $currentUser = Auth::user();
                // WHP responded with server error
                if (!$response || $response['status'] >= 500) {
                    if($currentUser){
                        $manager->removeStoredCreditTransactionFromCart($cart['id'], $currentUser->storeCreditAccount->id);
                    }
                    Log::error($this->normalizeCartId($cart['id'], true) . ' - WeHandlePay direct payment reqeust responded with an error.');
                    $this->logFailedAttempt($cart, $response, $card);
                    return redirect('cart/error');
                }
                // WHP responded with a processing error
                elseif ($response['status'] >= 400) {
                    if($currentUser){
                        $manager->removeStoredCreditTransactionFromCart($cart['id'], $currentUser->storeCreditAccount->id);
                    }
                    Log::error($this->normalizeCartId($cart['id'], true) . ' - WeHandlePay direct payment reqeust responded with an error.');
                    $this->logFailedAttempt($cart, $response, $card);
                    return redirect('cart/failed')->with('errors', $response['content']['error']);
                }
                // Successfully Processed Card
                elseif ($response['status'] == 200 || $response['status'] == 201) {
                    $content = $response['content'];

                    // This response contains a PayPal TXN and status is completed
                    if (isset($content['data']['transaction_ref']) && $content['data']['status'] == 'completed') {

                        // Complete the checkout process and retrieve the stored order
                        Log::info($this->normalizeCartId($cart['id'], true) . ' - Successfully captured direct payment.');

                        $order = $this->completeCartCheckout($content['data']['id'], $content['data']['transaction_ref']);//////PROCESSING THE ORDER AFTER PAYMENT///////

                        return $this->orderSuccesful($request, $order, $cart['id']);

                    }
                    // Cannot validate this transaction response
                    else {
                        Log::info($this->normalizeCartId($cart['id'], true) . ' - Direct payment capture response invalid.');
                        $this->logFailedAttempt($cart, $response, $card);
                        return redirect('cart/error');
                    }
                }
                // Unknown Response
                else {
                    Log::error($this->normalizeCartId($cart['id'], true) . ' - Unknown response received from WHP.');
                }
            }
        }
        // If cart status is not 0 otherwise, make a fuss about it
        // and log this incident
        else {
            Log::error($this->normalizeCartId($cart['id'], true) . ' - Attempt to checkout a pending cart.');
            return redirect('cart/error');
        }

        $errors = $this->errors();

        return back()->with([
            'errors' => $this->humanizeErrors($errors),
            'input' => $request->old()
        ]);
    }

    /**
     * @param Request $request
     * @param array $order
     */
    protected function orderSuccesful(Request $request, $order, $cartId)
    {
        $request->session()->put('order_id', @$order['id']);
        // regenerate session to start new cart.
        $request->session()->regenerate();
        $creditApplied = NULL;
        if(Auth::check()){
            $user = Auth::user();
            $user->load('storeCreditAccount');
            $creditApplied = (new Manager)->getStoreCreditAmountAppliedToCart($user->storeCreditAccount->id, $cartId);
        }
        $request->session()->flash('creditApplied', $creditApplied);
        return redirect('cart/success');
    }

    public function getPaypal (Request $request)
    {
        // Force any pending transactions to be reset
        $this->carts->resetTransaction();

        // Retrieve the current state of the cart
        $cart = $this->checkForStoreCreditsAppliedBeforePayment($this->carts->fetch());

        // Make sure the cart has items
        if (count($cart['items']) === 0) {
            Log::warning($this->normalizeCartId($cart['id'], true) . ' - Requesting authorization on an empty cart.');
            return redirect('cart');
        }

        $token = str_replace('=', '', Crypt::encrypt($cart['id']));

        // Get an authorization
        Log::info($this->normalizeCartId($cart['id'], true) . ' - Authorizing payment.' . PHP_EOL . json_encode($cart, JSON_PRETTY_PRINT));
        $response = $this->requestWhpPaymentAuthorization($cart, url('cart/callback/'.$token), url('cart/callback'));
        Log::info($this->normalizeCartId($cart['id'], true) . ' - Authorization response: ' . PHP_EOL . json_encode($response, JSON_PRETTY_PRINT));

        // Valid Response Received
        // + Response exists
        // + Status is 200 or 201
        // + Data object exists
        if ($response && ($response['status'] == 201 || $response['status'] == 200) && isset($response['content']['data'])) {
            $this->carts->patch([
                'transaction_id' => $response['content']['data']['id'],
            ], false);

            return redirect($response['content']['data']['redirect']['approval_url']);
        }

        // Invalid or Error Response Received
        else {
            // Log Error
            Log::error($this->normalizeCartId($cart['id'], true) . ' - Attempt to authorize payment failed.');
            $this->logFailedAttempt($cart, $response);
            return redirect('cart/error');
        }
    }

    public function getCallback(Request $request, $token = null)
    {
        // Get the current state of the cart
        $cart = $this->checkForStoreCreditsAppliedBeforePayment($this->carts->fetch());

        // Make sure the cart has items
        if (count($cart['items']) === 0) {
            Log::warning($this->normalizeCartId($cart['id'], true) . ' - Received a callback for an empty cart.');
            return redirect('cart');
        }

        // Decrypt the attached token
        try {
            $id = Crypt::decrypt($token);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Log::info($this->normalizeCartId($cart['id'], true) . ' - Cancel callback from PayPal.');
            return response()->view('cart.popup', [
                'redirect' => url('cart/payment')
            ]);
        }

        Log::info($this->normalizeCartId($cart['id'], true) . ' - Success callback form PayPal.');

        // Decrypted token must be same as cart id
        if ($id == $cart['id']) {
            // At this point we can assume that the payment succeeded since
            // there's little reason why we get this far without passing all
            // the other checks and validations. However, we still need to
            // collect some information from PayPal via WHP so we make another
            // call to get an updated payment information.
            Log::info($this->normalizeCartId($cart['id'], true) . ' - Retrieving payment status from WHP.');
            $response = $this->requestWhpPaymentStatus($cart);
            Log::info($this->normalizeCartId($cart['id'], true) . ' - Request response:' . PHP_EOL . json_encode($response, JSON_PRETTY_PRINT));

            // A successful response should be status 200 and must contain
            // a data object which will contain the additional information
            // we need
            if ($response && $response['status'] == 200 && isset($response['content']['data'])) {

                // Let's validate WHP response and log the validated results
                // in case we might need it later
                $details = $this->validateWhp($response['content']['data']);
                Log::info($this->normalizeCartId($cart['id'], true) . ' - Payment successfully authorized.');

                // We won't be overriding any information currently on the cart
                // isset($cart['contact_firstname']) ? $details['contact_firstname'] = $cart['contact_firstname'] : 0;
                // isset($cart['contact_lastname']) ? $details['contact_lastname'] = $cart['contact_lastname'] : 0;
                // isset($cart['contact_email']) ? $details['contact_email'] = $cart['contact_email'] : 0;
                // if ($this->passes()) {
                //     $details = $this->computeAdditionalCharges($details, $cart['sub_total']);
                // }
                // // Save any valid information regardless
                // $this->carts->patch($details, false);

                // TODO: Capture this payment and create the order
                Log::info($this->normalizeCartId($cart['id'], true) . ' - Capturing payment.');
                $response = $this->requestWhpPaymentCapture($cart);
                Log::info($this->normalizeCartId($cart['id'], true) . ' - Capture response:' . PHP_EOL . json_encode($response, JSON_PRETTY_PRINT));

                // WHP responded with server error
                if (!$response || $response['status'] >= 500) {
                    Log::error($this->normalizeCartId($cart['id'], true) . ' - WeHandlePay direct payment reqeust responded with an error.');
                    $this->logFailedAttempt($cart,$response);
                    return redirect('cart/error');
                }
                // WHP responded with a processing error
                elseif ($response['status'] >= 400) {
                    Log::error($this->normalizeCartId($cart['id'], true) . ' - WeHandlePay direct payment reqeust responded with an error.');
                    $this->logFailedAttempt($cart,$response);
                    return redirect('cart/failed')->with('errors', $response['content']['error']);
                }
                // Successfully Processed Card
                elseif ($response['status'] == 200 || $response['status'] == 201) {
                    $content = $response['content'];

                    // This response contains a PayPal TXN and status is completed
                    if (isset($content['data']['transaction_ref']) && $content['data']['status'] == 'completed') {

                        // Complete the checkout process and retrieve the stored order
                        Log::info($this->normalizeCartId($cart['id'], true) . ' - Successfully captured payment.');

                        $order = $this->completeCartCheckout($content['data']['id'], $content['data']['transaction_ref']);

                        //Order succesful
                        $request->session()->put('order_id', @$order['id']);

                        return redirect('cart/success');
                    }
                    // Cannot validate this transaction response
                    else {
                        Log::info($this->normalizeCartId($cart['id'], true) . ' - Payment capture response invalid.');
                        $this->logFailedAttempt($cart,$response);
                        return redirect('cart/error');
                    }
                }
                // Unknown response
                else {
                    Log::error($this->normalizeCartId($cart['id'], true) . ' - Unknown response received from WHP.');
                }
            }

            // This transaction doesn't exist?
            // Don't know how this could happen, but it shouldn't
            // But in case it does, let's log it
            elseif ($response && $response['status'] == 404) {
                // Log this incident
                Log::warning($this->normalizeCartId($cart['id'], true) . ' - Attempted to fetch unavailable payment information from WeHandlPay.');

                // Clear tranaction_ref and id to reset transaction
                $this->carts->resetTransaction();
            }

            // No response
            // Server error?
            else {
                // Log this incident
                Log::error($this->normalizeCartId($cart['id'], true) . ' - Attempt to fetch payment information from WeHandlePay failed.');

                // Clear tranaction_ref and id to reset transaction
                $this->carts->resetTransaction();
            }

        }

        // return response()->view('cart.popup', [
        //     'redirect' => url('cart/error')
        // ]);

        return redirect('cart/error');
    }

    public function getSuccess (Request $request)
    {
        $this->setViewName('CartSuccess');

        if ($order_id = $request->session()->pull('order_id')) {
            return response()->view('cart.success', [
                'cart' => $this->carts->setSessionId()->withClosedCarts()->fetch('order_id', $order_id),
                'is_root_domain' => $this->domain->isRootDomain()
            ]);
        } else {
            return redirect('cart');
        }
    }

    public function getFailed (Request $request)
    {
        $cart = $this->carts->fetch();
        $errors = $request->session()->pull('errors');

        $message = '';
        if (is_array($errors)) {
            foreach ($errors as $error) {
                $message .= (is_array($error) ? implode(' ', $error) : $error) . ' ';
            }
        }

        Log::warning($this->normalizeCartId($cart['id'], true) . ' - Payment Failed!'. PHP_EOL . 'Message: ' . $message);

        $this->setViewName('cartFailed');

        return response()->view('cart.failed', [
            'message' => $message
        ]);
    }

    public function getError (Request $request)
    {
        $this->setViewName('cartError');
        return response()->view('cart.error');
    }

    public function getAreYouAlive (Request $request)
    {
        return response('Yes');
    }

    public function logFailedAttempt ($cart=array(), $response=array(), $card=array()){

        $errors = $response['content'][ 'error'];
        $message = '';
        if (is_array($errors)) {
            foreach ($errors as $error) {
                $message .= (is_array($error) ? implode(' ', $error) : $error) . ' ';
            }
        }

        $data['cart_id'] = !empty($cart['id']) ? $cart['id'] : null;
        $data['ip'] = !empty($cart['ip']) ? $cart['ip'] : $this->get_client_ip();
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['amount'] = !empty($cart['total']) ? $cart['total'] : 0;
        $data['failed_message'] = $message;
        $data['processor_code'] = !empty($response['status']) ? $response['status'] : 0;

        if(!empty($card)){
            $data['transaction_type'] = 'credit_card';
            $data['card_last_four'] = !empty($card['number']) ? substr($card['number'], -4) : '';
            $data['card_type'] = !empty($card['number']) ? $this->cardType($card['number']) : '';
        }

        if(!empty($data['cart_id'])){
            $attempt = new CartFailedAttempt;
            $attempt->fill($data);
            $attempt->save();
        }

    }
    // Function to get the client IP address
    public  function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
    * Return credit card type if number is valid
    * @return string
    * @param $number string
    **/
    function cardType($number)
    {
        $number=preg_replace('/[^\d]/','',$number);
        if (preg_match('/^3[47][0-9]{13}$/',$number))
        {
            return 'American Express';
        }
        elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
        {
            return 'Diners Club';
        }
        elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
        {
            return 'Discover';
        }
        elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
        {
            return 'JCB';
        }
        elseif (preg_match('/^5[1-5][0-9]{14}$/',$number))
        {
            return 'MasterCard';
        }
        elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
        {
            return 'Visa';
        }
        else
        {
            return null;
        }
    }
}
