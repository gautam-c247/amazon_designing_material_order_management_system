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
        // API Routes
        Route::prefix('api')
            ->middleware('api')
            ->group(function () {
                require base_path('routes/admin/api/category.php');
            });

        // Web Routes
        Route::middleware('web')
            ->group(function () {
                require base_path('routes/admin/web/category.php');
            });
        Route::prefix('api')
        ->middleware('api')
        ->group(function () {
            require base_path('routes/admin/api/user.php');
        });

    // Web Routes
    Route::middleware('web')
        ->group(function () {
            require base_path('routes/admin/web/user.php');
        });
    }
}
