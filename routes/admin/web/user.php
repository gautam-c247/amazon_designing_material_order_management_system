<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckUserActive;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\Admin\{RolesController, UserManagementController};

Route::prefix('admin')->middleware([AdminAuthMiddleware::class, CheckUserActive::class])->group(function () {
    Route::post('users/{id}/change-status', [UserManagementController::class, 'changeStatus'])->name('users.change-status');
    Route::resource('users', UserManagementController::class);
    Route::resource('roles', RolesController::class);
    Route::get('permissions', [RolesController::class, 'getPermissions']);
});
