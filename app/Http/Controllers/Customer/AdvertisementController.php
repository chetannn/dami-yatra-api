<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdvertisementController extends Controller
{
    public function index() : LengthAwarePaginator
    {
       return Advertisement::query()
            ->with(['vendor', 'tags'])
            ->withIsFavorite(auth()->user()->customer()->first())
            ->when(request()->filled('is_favorite'), function (Builder $query) {
                   $query->whereRelation('favoritedBy', 'customer_id', auth()->user()->customer()->first()->id);
               })
            ->latest()
            ->paginate(request('per_page', 6));
    }

    public function show(Advertisement $advertisement) : JsonResponse
    {
        return new JsonResponse($advertisement->load('vendor', 'tags'));
    }

    public function featuredAdvertisements()
    {

    }

    public function trackView(Advertisement $advertisement)
    {

    }

}
