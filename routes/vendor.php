<?php

use App\Http\Controllers\Vendor\AdvertisementController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::post('advertisements', [AdvertisementController::class, 'store'])->name('vendor.advertisement.store');
    Route::delete('advertisements/{advertisement}', [AdvertisementController::class, 'destroy'])->name('vendor.advertisement.destroy');
});
