<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke() : JsonResponse
    {
        $vendor = auth()->user()->vendor()->first();

        $customers = Customer::query()->count();
        $coupons = $vendor->coupons()->count();
        $views = $vendor->advertisements()
            ->where('status', 1)
            ->sum('clicks');
        $activeAds =  $vendor->advertisements()->where('status', 1)->count();
        $expiredAds =  $vendor->advertisements()->where('status', 3)->count();
        $draftedAds =  $vendor->advertisements()->where('status', 0)->count();
        $featuredAds =  $vendor->advertisements()->where('featured', 0)->count();
        $revenue = CustomerPayment::query()
            ->selectRaw('sum(taxable_amount - discount_amount) as total')
            ->whereIn('advertisement_id', function ($query) use($vendor) {
                $query->select('id')
                    ->from('advertisements')
                    ->where('vendor_id', $vendor->id);
            })
            ->first();


        $stats = [
            'customers' => $customers,
            'coupons' => $coupons,
            'views' => $views,
            'activeAds' => $activeAds,
            'expiredAds' => $expiredAds,
            'draftedAds' => $draftedAds,
            'featuredAds' => $featuredAds,
            'revenue' => $revenue
        ];

        return new JsonResponse(data: $stats);
    }
}
