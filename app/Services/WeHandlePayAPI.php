<?php

namespace Flavorgod\Services;

use Illuminate\Support\Collection;

class WeHandlePayAPI {

    /**
     * @var string  $apiurl     Url to direct API requests
     * @var string  $apikey     API key to use for WeHandlePay api transactions
     * @var string  $secret     API secret
     *
     */
    private $apiurl;
    private $apikey;
    private $secret;
    private $directPayCredId;
    private $capturePayCredId;

    protected $response;

    /**
     * Perform a request to the WeHandlePay API
     *
     */

    private function request($method = 'GET', $path = '', array $params = [], $payload = null)
    {
        $url = preg_replace('/\\/$/', '', $this->apiurl);
        $url = $url.'/'.preg_replace('/^\\//', '', $path);
        $credentials = $this->apikey.':'.$this->secret;
        $json = json_encode($payload);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $credentials);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . (isset($json) ? strlen($json) : 0)
        ]);

        $response = @curl_exec($ch);
        $header_size = @curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        curl_close($ch);

        $headers_raw = preg_split('/\\r\\n|\\n/i', substr($response, 0, $header_size));
        $body = @json_decode(substr($response, $header_size), true);

        $status = 500;
        $headers = [];

        foreach($headers_raw as $header) {
            $header = trim($header);
            if ($header !== '') {
                if (preg_match('/^(HTTP\\/[\\d\\.]+)\\s((\\d+)\\s.*)$/i', $header, $matches)) {
                    $headers['protocol'] = $matches[1];
                    $headers['status'] = $matches[2];
                    $status = (int) $matches[3];
                } elseif(preg_match('/^([a-z0-9\\-]+?):\\s(.*)$/i', $header, $matches)) {
                    $headers[strtolower($matches[1])] = $matches[2];
                }
            }
        }

        $this->response = [
            'status' => $status,
            'headers' => $headers,
            'content' => isset($body) ? $body : null
        ];

        return $this->response;
    }



    /**
     * Load values from the WeHandlePay configuration file and keep a local copy
     *
     */
    public function __construct() {
        $this->apiurl = config('whpapi.apiurl');
        $this->apikey = config('whpapi.apikey');
        $this->secret = config('whpapi.secret');
        $this->directPayCredId = config('whpapi.creds.direct');
        $this->capturePayCredId = config('whpapi.creds.capture');
    }

    /**
     * Get a listing of payments from the API
     *
     * @link http://api.wehandlepay.com/doc/#api-Payments-Index
     */
    public function listPayments($page = null, $external_id = null, $transaction_ref = null)
    {
        return $this->request('GET', '/payments', ['page' => $page, 'external_id' => $external_id, 'transaction_ref' => $transaction_ref]);
    }

    public function showPayment($id)
    {
        return $this->request('GET', '/payments/'.$id);
    }

    public function makePayment(array $payload)
    {
        $payload['credential_id'] = $this->directPayCredId;
        return $this->request('POST', '/payments', [], $payload);
    }

    public function requestAuthorization($extId, $amount, $returnUrl, $cancelUrl)
    {
        $payload = [
            'external_id'   => $extId,
            'credential_id' => $this->capturePayCredId,
            'amount'        => number_format($amount, 2, '.', ''),
            'redirect'      => [
                'return_url'    => $returnUrl,
                'cancel_url'    => $cancelUrl
            ]
        ];

        return $this->request('POST', '/payments', [], $payload);
    }

    public function executePayment($id, $amount, $currency = 'USD')
    {
        return $this->request('PUT', '/payments/'.$id, [], ['action' => 'complete', 'currency' => $currency, 'amount' => number_format($amount, 2, '.', '')]);
    }

    public function requestRefund($id, $amount)
    {
        return $this->requrest('POST', '/payments/'.$id.'/refunds', [], ['payment_id' => $id, 'amount' => number_format($amount, 2, '.', '')]);
    }

    public function response() {
        return $this->response;
    }
}