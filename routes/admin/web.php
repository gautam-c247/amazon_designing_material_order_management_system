<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\Admin\{ServiceController, NotificationController};

// ...existing code...

// Route::prefix('admin')->middleware([AdminAuthMiddleware::class])->group(function () {
//     // ...existing routes...


// });
