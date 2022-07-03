<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\KhaltiGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function store(Request $request, KhaltiGateway $gateway) : JsonResponse
    {
        $validated = $request->validate([
            'amount' => ['required'],
            'token' => ['required'],
            'advertisement_id' => ['required']
        ]);

        if($gateway->verify(token: $validated['token'], amount: $validated['amount'])) {
            // create payment for logged in customer

            return new JsonResponse(data: ['message' => 'Payment successful']);
        }
        else {
            return new JsonResponse(data: ['message' => 'Failed to Process Payment'], status: Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['success' => true]);
    }
}
