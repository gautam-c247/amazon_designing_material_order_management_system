<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->middleware([AdminAuthMiddleware::class])->group(function () {
    Route::post('category/{id}/change-status', [CategoryController::class, 'changeStatus']);
    Route::resource('category', CategoryController::class);
});
