<?php

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

});