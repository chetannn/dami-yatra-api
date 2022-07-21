<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\KhaltiGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class FeaturedAdPaymentController extends Controller
{
    public function store(Request $request, KhaltiGateway $gateway) : JsonResponse
    {
       $validated = $request->validate([
            'advertisement_id' => ['required', Rule::exists('advertisements', 'id')],
            'amount' => ['required'],
            'token' => ['required', 'string'],
            'type' => ['required', 'string']
        ]);

       // check if already payment is made. do not allow multiple payments for the same advertisement
        if(auth()->user()->vendor()->first()->payments()->where('advertisement_id', $validated['advertisement_id'])->exists()) {
            return new JsonResponse(data: ['message' => 'Already purchased.. if you want to switch your plan.. contact our team'], status: Response::HTTP_BAD_REQUEST);
        }

        if(!$gateway->verify(token: $validated['token'], amount: $validated['amount'])) {
            return new JsonResponse(data: ['message' => 'Fail to process payment.'], status: Response::HTTP_BAD_REQUEST);
        }

      auth()->user()->vendor()->first()
           ->payments()
           ->create(Arr::except($validated, ['token', 'amount']) + [
              'status' => 1,
               'amount' => $validated['amount'] / 100
           ]);

        return new JsonResponse(data: ['message' => 'Payment successful!']);
    }
}
