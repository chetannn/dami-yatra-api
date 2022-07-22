<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CustomerPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CouponVerificationController extends Controller
{
    public function __invoke(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'advertisement_id' => ['required', Rule::exists('advertisements', 'id')],
            'coupon_code' => ['required', 'string']
        ]);

       $limit = CustomerPayment::query()
            ->where('coupon_id', function ($query) use($validated) {
                $query
                    ->select('id')
                    ->from('coupons')
                    ->where('expiration_date', '>=', today())
                    ->where('name', $validated['coupon_code']);
            })
            ->count();

        $coupon = Coupon::query()
            ->where('name', $validated['coupon_code'])
            ->where('expiration_date', '>=', today())
            ->where('limit', '>=', $limit)
            ->first();

        if(blank($coupon)) {
            return new JsonResponse(['message' => 'Coupon does not exists or expired'], Response::HTTP_BAD_REQUEST);
        }

       $hasUsedCoupon = auth()->user()->customer()->first()->payments()
            ->where('advertisement_id', $validated['advertisement_id'])
            ->where('coupon_id', function ($query) use($validated) {
                $query
                     ->select('id')
                    ->from('coupons')
                    ->where('expiration_date', '>=', today())
                    ->where('name', $validated['coupon_code']);
            })
            ->exists();

        if($hasUsedCoupon) {
            return new JsonResponse(['message' => 'You have already used this coupon!'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($coupon);
    }
}
