<?php
// app/Services/DuitkuService.php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DuitkuService
{
    private $client;
    private $merchantCode;
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->merchantCode = config('duitku.merchant_code');
        $this->apiKey = config('duitku.api_key');
        $this->baseUrl = config('duitku.base_url');
    }

        // $this->merchantCode = config('duitku.DS23372');
        // $this->apiKey = config('duitku.e4dcf04a963be54aea6913089c1e3085');
        // $this->baseUrl = config('duitku.base_url');

    public function createInvoice($data)
    {
        try {
            $signature = $this->generateSignature($data);
            
            $payload = [
                'merchantCode' => $this->merchantCode,
                'paymentAmount' => $data['amount'],
                'paymentMethod' => $data['payment_method'] ?? 'M2', // Default to Mandiri VA
                'merchantOrderId' => $data['invoice_id'],
                'productDetails' => $data['product_details'],
                'customerVaName' => $data['customer_name'],
                'email' => $data['email'],
                'phoneNumber' => $data['phone'] ?? '',
                'itemDetails' => [
                    [
                        'name' => 'Deposit Saldo',
                        'price' => $data['amount'],
                        'quantity' => 1
                    ]
                ],
                'customerDetail' => [
                    'firstName' => $data['customer_name'],
                    'email' => $data['email']
                ],
                'callbackUrl' => route('deposit.callback'),
                'returnUrl' => route('deposit.return'),
                'signature' => $signature,
                'expiryPeriod' => 60 // 60 minutes
            ];

            $response = $this->client->post($this->baseUrl . '/webapi/api/merchant/v2/inquiry', [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            
            Log::info('Duitku Create Invoice Response', $result);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Duitku Create Invoice Error: ' . $e->getMessage());
            return [
                'statusCode' => '01',
                'statusMessage' => 'Payment gateway error: ' . $e->getMessage()
            ];
        }
    }

    public function checkTransaction($merchantOrderId)
    {
        try {
            $signature = md5($this->merchantCode . $merchantOrderId . $this->apiKey);
            
            $payload = [
                'merchantCode' => $this->merchantCode,
                'merchantOrderId' => $merchantOrderId,
                'signature' => $signature
            ];

            $response = $this->client->post($this->baseUrl . '/webapi/api/merchant/transactionStatus', [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            
            Log::info('Duitku Check Transaction Response', $result);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Duitku Check Transaction Error: ' . $e->getMessage());
            return [
                'statusCode' => '01',
                'statusMessage' => 'Payment gateway error: ' . $e->getMessage()
            ];
        }
    }

    private function generateSignature($data)
    {
        $signature = md5(
            $this->merchantCode . 
            $data['invoice_id'] . 
            $data['amount'] . 
            $this->apiKey
        );
        
        return $signature;
    }

    public function validateCallback($request)
    {
        $merchantOrderId = $request->input('merchantOrderId');
        $amount = $request->input('amount');
        $signature = $request->input('signature');
        
        $expectedSignature = md5(
            $this->merchantCode . 
            $amount . 
            $merchantOrderId . 
            $this->apiKey
        );
        
        return $signature === $expectedSignature;
    }
}