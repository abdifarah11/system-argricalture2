<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;



class PaymentService
{
    /**
     * Process a payment request.
     *
     * @param array $data
     * @return array
     */


//     { 
//         "schemaVersion": "1.0", 
//         "requestId": "10111331033", 
//         "timestamp": "client_timestamp", 
//         "channelName": "WEB", 
//         "serviceName": "API_PURCHASE", 
//         "serviceParams": { 
//           "merchantUid": "M0910291", 
//           "apiUserId": "1000416",  
//           "apiKey": "API-675418888AHX", 
//           "paymentMethod": "mwallet_account", 
//           "payerInfo": { 
//             "accountNo": "252618827482" 
//           }, 
//           "transactionInfo": { 
//             "referenceId": "12334",
//             "invoiceId": "7896504",
//             "amount": 1.00,  
//             "currency": "USD", 
//             "description": "Test USD" 
//           } 
//         } 
// }
    public function pay(array $data): array
    {

        
        $payload= [
            "schemaVersion" => "1.0",
            "requestId" => uniqid(),
            "timestamp" =>time(),
            "channelName" => "WEB",
            "serviceName" => "API_PURCHASE",
            "serviceParams" => [
                 "merchantUid"    => config('services.payment.merchant_uid'),
                "apiUserId"      => config('services.payment.api_user_id'),
                "apiKey"         => config('services.payment.api_key'),
                "paymentMethod" =>"mwallet_account",
                "payerInfo" => [
                    "accountNo" => $data['sender'],
                ],
                "transactionInfo" => [
                    "referenceId" => uniqid(),
                    "invoiceId" => uniqid(),
                    "amount" => $data['amount'] ??0.00,
                    "currency" => "USD",
                    "description" => $data['description'] ?? "",
                ]
            ]
        ];

       
        $url = "https://api.waafipay.net/asm";

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        // ])->post($url, $payload);
        $response = Http::timeout(60)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post($url, $payload);

      //  return $response->json();
 // ✅ Always return an array
        return $response->json() ?? [];
       
    }
}

