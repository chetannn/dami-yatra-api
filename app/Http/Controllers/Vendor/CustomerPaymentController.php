<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerPaymentController extends Controller
{
    public function index() : JsonResponse
    {
        return new JsonResponse(data: auth()->user()->vendor()->first()
            ->customerPayments()
            ->with('advertisement','customer')
            ->paginate(request('per_page', 10)));
    }
}
