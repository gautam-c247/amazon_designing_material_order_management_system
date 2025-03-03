<?php

use App\Http\Controllers\Merchant\BrandController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','role:merchant'])->group(function(){
    Route::resource('brands', BrandController::class)->names([
        'index'   => 'merchant.brand.index',
        'create'  => 'merchant.brand.create',
        'store'   => 'merchant.brand.store',
        'show'    => 'merchant.brand.show',
        'edit'    => 'merchant.brand.edit',
        'update'  => 'merchant.brand.update',
        'destroy' => 'merchant.brand.destroy',
    ]);
    Route::post('brand/{id}/change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
