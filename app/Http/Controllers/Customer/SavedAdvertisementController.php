<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class SavedAdvertisementController extends Controller
{
    public function index() : LengthAwarePaginator
    {
        return auth()->user()->customer()->first()
            ->savedAdvertisements()
             ->with('advertisement')
              ->paginate(request('per_page', 10));
    }

    public function toggle(Request $request) : JsonResponse
    {
        $validated =$request->validate([
            'advertisement_id' => ['required', Rule::exists('advertisements', 'id')]
        ]);

        auth()->user()->customer()->first()
            ->savedAdvertisements()->toggle($validated['advertisement_id']);

        return new JsonResponse(true);
    }
}
