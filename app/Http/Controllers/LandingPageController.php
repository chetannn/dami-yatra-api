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
            ->when(request()->filled('keyword'), function ($query) {
                $query->where(function ($query) {
                    $keyword = request('keyword');
                    $query->where('title', 'like', "%$keyword%")
                        ->orWhere('description', 'like', "%$keyword%");
                });
            })
            ->where('ad_end_date', '>=', today())
            ->where('status', 1)
            ->latest()
            ->paginate(request('per_page', 6));

        return new JsonResponse(data: $ads);
    }
}
