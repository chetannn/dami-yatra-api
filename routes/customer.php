<?php

use App\Http\Controllers\Customer\AdvertisementController;
use App\Http\Controllers\Customer\AdvertisementDiscussionController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\SavedAdvertisementController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/advertisements', [AdvertisementController::class, 'index']);
    Route::get('/advertisements/{advertisement}', [AdvertisementController::class, 'show']);
    Route::post('/advertisements/views/{advertisement}', [AdvertisementController::class, 'show']);
    Route::get('/saved-advertisements', [SavedAdvertisementController::class, 'index']);
    Route::post('/saved-advertisements/toggle', [SavedAdvertisementController::class, 'toggle'])->name('saved_advertisements.toggle');
    Route::post('/pay', [PaymentController::class, 'store']);
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::apiResource('advertisement-discussions', AdvertisementDiscussionController::class)->only('store', 'index');
});


