<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers\Api\Auth'], function () {
    // Public routes
    Route::post('/login', LoginController::class)->name('api.auth.login');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', LogoutController::class)->name('api.auth.logout');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
        Route::get('markets', Market\ListController::class)->name('api.market.list');
        Route::post('report/job-bookings', Report\JobBookingController::class)->name('api.report.job-bookings');
        Route::post('report/conversion-funnel', Report\ConversionFunnelController::class)->name('api.report.conversion-funnel');
    });
});