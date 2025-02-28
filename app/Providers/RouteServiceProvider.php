<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    // Web Routes
        Route::middleware('web')
        ->group(function () {
            require base_path('routes/admin/web/category.php');
        });
     Route::middleware('web')
        ->group(function () {
            require base_path('routes/admin/web/admin.php');
        });
    // Web Routes
    Route::middleware('web')
        ->group(function () {
            require base_path('routes/admin/web/user.php');
        });
    }
}
