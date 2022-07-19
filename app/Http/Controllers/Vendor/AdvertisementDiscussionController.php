<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementDiscussion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementDiscussionController extends Controller
{

    public function index(Advertisement $advertisement) : JsonResponse
    {
        $discussions = AdvertisementDiscussion::query()
            ->whereBelongsTo($advertisement)
            ->with('customer', 'customer.user', 'advertisement', 'advertisement.vendor.user')
            ->get();

        return new JsonResponse(data: $discussions);
    }

    public function store(Request $request) : JsonResponse
    {
         $validated = $request->validate([
            'message' => ['required', 'string'],
            'advertisement_id' => ['required', Rule::exists('advertisements', 'id')],
        ]);

        $validated['sender_type'] = 'vendor';

        auth()->user()->vendor()->first()->discussions()->create($validated);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

}
