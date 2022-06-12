<?php

use App\Http\Controllers\Vendor\AdvertisementController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::post('advertisements', [AdvertisementController::class, 'store'])->name('vendor.advertisement.store');
    Route::put('advertisements/{advertisement}', [AdvertisementController::class, 'update'])->name('vendor.advertisement.update');
    Route::get('advertisements', [AdvertisementController::class, 'index'])->name('vendor.advertisement.index');
    Route::delete('advertisements/{advertisement}', [AdvertisementController::class, 'destroy'])->name('vendor.advertisement.destroy');
});
