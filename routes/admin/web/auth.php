<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailResetController;
use App\Http\Controllers\Admin\NewPasswordController;
use App\Http\Controllers\Auth\NewPasswordController as AuthNewPasswordController;

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});
Route::middleware('guest')->group(function () {
    Route::get('reset-password/{token}', [AuthNewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [AuthNewPasswordController::class, 'store'])
        ->name('password.store');
});
Route::prefix(config('admin.route_prefix'))->group(function () {
    //login routes
    Route::middleware(RedirectIfAuthenticated::class)->group(function () {
        Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
        Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.forgot-password');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('admin.reset-password');
        Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('admin.password.reset');
        Route::post('/store-password', [NewPasswordController::class, 'store'])->name('admin.password.store');
    });
    //user.active middleware is used to check whether the user is active or not
    Route::middleware(AdminAuthMiddleware::class, 'user.active')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        // profile routes
        Route::get('/profile', [AuthController::class, 'profile'])->name('admin.profile');
        Route::post('/update-profile-picture', [AuthController::class, 'updateProfilePicture'])->name('admin.update-profile-picture');
        Route::post('/delete-profile-picture', [AuthController::class, 'deleteProfilePicture'])->name('admin.delete-profile-picture');
        Route::get('/edit-profile', [AuthController::class, 'editProfile'])->name('admin.edit-profile');
        Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('admin.update-profile');
        Route::get('/change-password', [AuthController::class, 'editPassword'])->name('admin.edit-password');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('admin.change-password');


        //dashboard route
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        });

    });
    Route::get('/email-reset', [EmailResetController::class, 'showEmailResetForm'])->name('email.reset.form');
    Route::post('/email-reset', [EmailResetController::class, 'submitEmailReset'])->name('email.reset.submit');
    Route::get('/email-reset/confirm/{token}', [EmailResetController::class, 'confirmEmailReset'])->name('email.reset.confirm');

});
