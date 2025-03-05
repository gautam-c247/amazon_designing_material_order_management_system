<?php

use App\Http\Controllers\Merchant\BrandController;
use App\Http\Controllers\Merchant\ProductController;
use App\Http\Controllers\Merchant\ProjectController;
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
    // resource route for brands
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
   // resource route for products
    Route::resource('products', ProductController::class)->names([
        'index'   => 'merchant.product.index',
        'create'  => 'merchant.product.create',
        'store'   => 'merchant.product.store',
        'show'    => 'merchant.product.show',
        'edit'    => 'merchant.product.edit',
        'update'  => 'merchant.product.update',
        'destroy' => 'merchant.product.destroy',
    ]);
    Route::post('product/{id}/change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
    Route::delete('product/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('merchant.product.delete-image');
// project routes
    Route::resource('projects', ProjectController::class)->names([
        'index'   => 'merchant.project.index',
        'create'  => 'merchant.project.create',
        'store'   => 'merchant.project.store',
        'show'    => 'merchant.project.show',
        'edit'    => 'merchant.project.edit',
        'update'  => 'merchant.project.update',
        'destroy' => 'merchant.project.destroy',
    ]);
    Route::post('project/{id}/change-status', [ProjectController::class, 'changeStatus'])->name('project.change-status');
    Route::delete('project/delete-image/{id}', [ProjectController::class, 'deleteImage'])->name('merchant.project.delete-image');
    Route::get('/project/get-products-by-brand', [ProjectController::class, 'fetchProducts'])->name('merchant.project.fetchProducts');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
