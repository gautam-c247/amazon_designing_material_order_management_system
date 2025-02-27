<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnforceJson;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\Admin\CategoryController;

Route::middleware([EnforceJson::class, JwtMiddleware::class])->prefix('admin')->group(function () {
    Route::resource('category', CategoryController::class);
});
