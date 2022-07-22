<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class LandingPageController extends Controller
{
    public function index() : JsonResponse
    {
        $ads =  Advertisement::query()
            ->withCount([
                'purchasedBy' => function(Builder $query) {
                    $query->where('status', 1);
                }
            ])
            ->with(['vendor', 'tags'])
            ->where('ad_end_date', '>=', today())
            ->where('status', 1)
            ->latest()
            ->paginate(request('per_page', 6));

        return new JsonResponse(data: $ads);
    }
}
