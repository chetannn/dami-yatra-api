<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends Controller
{
    public function index() : LengthAwarePaginator
    {
        return auth()->user()
            ->vendor()
            ->first()
            ->coupons()
            ->paginate(\request('per_page', 10));
    }
    public function store(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'discount_rate' => ['required'],
            'limit' => ['required', 'integer'],
            'expiration_date' => ['required', 'date'],
        ]);

      $coupon = auth()->user()->vendor()->first()
            ->coupons()->create($validated);

        return new JsonResponse(data: $coupon, status: Response::HTTP_CREATED);
    }

}
