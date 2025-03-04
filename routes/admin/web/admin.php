<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\NotificationController;

use App\Http\Middleware\CheckUserActive;
use App\Http\Middleware\AdminAuthMiddleware;

Route::prefix('admin')->middleware([AdminAuthMiddleware::class, CheckUserActive::class])->group(function () {
    Route::post('service/{id}/change-status', [ServiceController::class, 'changeStatus']);
    Route::resource('service', ServiceController::class);
    Route::resource('notification', NotificationController::class);
});
