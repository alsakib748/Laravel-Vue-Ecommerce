<?php

use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SizeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\HomeBannerController;

Route::get('/dashboard', function () {
    return view('admin/index');
})->middleware('admin')->name('admin.dashboard');

Route::middleware(['admin', 'auth'])->group(function () {


    // Additional admin routes can be added here
    // todo: Profile Section
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/save/profile', [ProfileController::class, 'store'])->name('save.profile');


    // todo: Home Banner
    Route::get('/home_banner', [HomeBannerController::class, 'index']);
    Route::post('/updateHomeBanner', [HomeBannerController::class, 'store'])->name('homebanner.store');

    // todo: Size
    Route::get('/manage_size', [SizeController::class, 'index']);
    Route::post('/updateSize', [SizeController::class, 'store'])->name('size.store');

    // todo: Color
    Route::get('/manage_color', [ColorController::class, 'index']);
    Route::post('/updateColor', [ColorController::class, 'store'])->name('color.store');

    Route::get('/deleteData/{id?}/{table?}', [DashboardController::class, 'deleteData'])->name('delete.data');

});