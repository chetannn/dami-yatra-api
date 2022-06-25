<?php

use App\Http\Controllers\Vendor\AdvertisementController;
use App\Http\Controllers\Vendor\CouponController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/advertisements', [AdvertisementController::class, 'index'])->name('vendor.advertisement.index');
    Route::get('/advertisements/{advertisement}', [AdvertisementController::class, 'show']);
    Route::post('/advertisements', [AdvertisementController::class, 'store'])->name('vendor.advertisement.store');
    Route::put('/advertisements/{advertisement}', [AdvertisementController::class, 'update'])->name('vendor.advertisement.update');
    Route::delete('/advertisements/{advertisement}', [AdvertisementController::class, 'destroy'])->name('vendor.advertisement.destroy');

    Route::apiResource('/coupons', CouponController::class);
});
