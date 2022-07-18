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
            auth()->user()->customer()->first()
                ->payments()
                ->create([
                    'total_amount_with_tax' => $validated['amount'] / 100,
                    'advertisement_id' => $validated['advertisement_id'],
                    'status' => 1
                ]);

            // send email to vendor
            // send invoice to customer

            return new JsonResponse(data: ['message' => 'Payment successful']);
        }
        else {
            return new JsonResponse(data: ['message' => 'Failed to Process Payment'], status: Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['success' => true]);
    }
}
