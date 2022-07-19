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
             ->withCount([
                 'purchasedBy' => function(Builder $query) {
                   $query->where('status', 1);
                 }
             ])
            ->with(['vendor', 'vendor.user', 'tags'])
            ->withIsFavorite(auth()->user()->customer()->first())
            ->when(request()->filled('is_favorite'), function (Builder $query) {
                   $query->whereRelation('favoritedBy', 'customer_id', auth()->user()->customer()->first()->id);
               })
           ->when(request()->filled('is_purchased'), function (Builder $query) {
               $query->whereRelation('purchasedBy', 'customer_id', auth()->user()->customer()->first()->id);
           })
            ->where('ad_end_date', '>=', today())
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
