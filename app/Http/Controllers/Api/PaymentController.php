<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\paymentRequest;
use App\Services\PaymentService;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    //

    protected $payment_service;
    public function __construct(PaymentService $payment_service){
        $this->payment_service=$payment_service;

    }
    public Function send(paymentRequest $request){
        $validated=$request->validated();
        $data=[
            'sender'=>trim($validated['sender'],'0'),
            'amount'=>$validated['amount'],
            'description'=>$validated['description'],
        ];

        $result=$this->payment_service->pay($data);
           $resCode = $result['responseCode'] ?? null;

        if ($resCode === '2001') {
            return response()->json(['message' => 'successfully'], 200);
        } elseif ($resCode === '5306') {
            return response()->json(['message' => 'unsuccessfully'], 400);
        }

        return response()->json([
            'message' => 'unknown response',
            'data' => $result
        ], 500);



    }
}
