<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\{EnforceJson, JwtMiddleware};
use App\Http\Controllers\Admin\{RolesController, UserManagementController};

Route::middleware([EnforceJson::class, JwtMiddleware::class])->prefix('admin')->group(function () {
    Route::resource('users', UserManagementController::class);
    Route::resource('roles', RolesController::class);
    Route::get('permissions', [RolesController::class, 'getPermissions']);
});
