<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Services\KhaltiGateway;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function index() : JsonResponse
    {
        return new JsonResponse(data: auth()->user()
            ->customer()
            ->first()
            ->payments()
            ->with('advertisement')
            ->paginate(\request('per_page', 10))
        );
    }

    public function store(Request $request, KhaltiGateway $gateway) : JsonResponse
    {
        $validated = $request->validate([
            'amount' => ['required'],
            'token' => ['required'],
            'advertisement_id' => ['required', Rule::exists('advertisements', 'id')]
        ]);

        // check if already paid for this advertisement
        if(auth()->user()->customer()->first()->payments()->where('advertisement_id', $validated['advertisement_id'])->exists()) {
            return new JsonResponse(data: ['message' => 'You have already purchased this advertisement'], status: Response::HTTP_BAD_REQUEST);
        }

        // check if all the bookings are made for this particular advertisement
       $hasRemainingBookings = Advertisement::query()
            ->where('quantity', '>=', function (Builder $query) use($validated) {
                $query->from('customer_payments')
                    ->selectRaw('count(1)')
                    ->whereColumn('customer_payments.advertisement_id', 'advertisements.id')
                    ->where('status', 1)
                    ->limit(1);
            })
            ->find($validated['advertisement_id'])
            ->exists();

        if(!$hasRemainingBookings) {
            return new JsonResponse(data: ['message' => 'All of the advertisements are already booked.. please come back later'], status: Response::HTTP_BAD_REQUEST);
        }

        if($gateway->verify(token: $validated['token'], amount: $validated['amount'])) {
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

    }
}
